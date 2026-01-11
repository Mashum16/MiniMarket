<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    public function run(): BinaryFileResponse
    {
        // supaya nggak timeout
        set_time_limit(300);

        // perintah backup php
        Artisan::call('backup:run');

        // masuk ke folder laravel
        $backupPath = storage_path('app/Laravel');

        // ngambil file nya yang tadi di laravel (file nya tidak akan muncul di folder laravel karena diambil untuk di download)
        $files = File::files($backupPath);

        if (empty($files)) {
            abort(404, 'File backup tidak ditemukan');
        }

        // sortir berdasarkan waktu
        usort($files, function ($a, $b) {
            return $b->getMTime() <=> $a->getMTime();
        });

        $latestBackup = $files[0];

        // file nya di download
        return response()->download($latestBackup->getPathname())
            ->deleteFileAfterSend(false);
    }
}
