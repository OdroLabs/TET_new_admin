<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = [
        'is_enabled', 'host', 'port', 'encryption', 'username', 'password',
        'from_address', 'from_name', 'to_addresses', 'cc_addresses',
        'notify_contact', 'notify_inquiries', 'notify_donations',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_enabled' => 'boolean',
        'port' => 'integer',
        'password' => 'encrypted',
        'to_addresses' => 'array',
        'cc_addresses' => 'array',
        'notify_contact' => 'boolean',
        'notify_inquiries' => 'boolean',
        'notify_donations' => 'boolean',
    ];

    /** The single settings row (created on first access). */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'is_enabled' => false,
            'port' => 587,
            'encryption' => 'tls',
            'from_name' => 'Trans Equality Trust',
            'to_addresses' => [],
            'cc_addresses' => [],
            'notify_contact' => true,
            'notify_inquiries' => true,
            'notify_donations' => true,
        ])->refresh();
    }
}
