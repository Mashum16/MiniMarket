<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Menampilkan seluruh data audit log
     */
    public function index()
    {
        $logs = AuditLog::orderBy('created_at', 'desc')->get();
        return view('audit.index', compact('logs'));
    }

    /**
     * Menampilkan detail audit log tertentu
     */
    public function show($id)
    {
        $log = AuditLog::findOrFail($id);
        return view('audit.show', compact('log'));
    }

    /**
     * Filter audit log berdasarkan user dan aksi
     */
    public function filter(Request $request)
    {
        $query = AuditLog::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        return view('audit.index', compact('logs'));
    }

    /**
     * Menghapus satu audit log (OPSIONAL)
     * Biasanya audit log tidak dihapus
     */
    public function destroy($id)
    {
        $log = AuditLog::findOrFail($id);
        $log->delete();

        return redirect()->route('audit.index')
            ->with('success', 'Audit log berhasil dihapus');
    }
}
