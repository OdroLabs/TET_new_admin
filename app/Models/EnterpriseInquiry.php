<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseInquiry extends Model
{
    protected $fillable = [
        'reference', 'type', 'customer_name', 'customer_phone', 
        'customer_email', 'item_name', 'quantity', 'estimated_total', 
        'message', 'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'estimated_total' => 'float',
    ];
}