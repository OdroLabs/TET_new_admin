<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'reference', 'donor_name', 'donor_email', 'amount', 
        'currency', 'payment_method', 'is_anonymous', 'status', 'notes'
    ];

    protected $casts = [
        'amount' => 'float',
        'is_anonymous' => 'boolean',
    ];
}