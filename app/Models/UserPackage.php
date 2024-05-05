<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'package_id',
        'payment_id',
        'start_date',
        'end_date',
        'subscription_type',
        'status',
        'is_trail',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
