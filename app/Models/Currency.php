<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'currency_code',
        'symbol',
        'currency_placement',
        'current_currency'
    ];
}
