<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomDomainRequest extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'old_domain',
        'request_domain',
        'status',
    ];
}
