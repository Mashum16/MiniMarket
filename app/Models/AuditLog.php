<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'table_name',
        'record_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    // 🔐 Enkripsi IP otomatis
    protected function ipAddress(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
