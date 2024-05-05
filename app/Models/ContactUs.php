<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    protected $fillable =
        [
            'tenant_id',
            'name',
            'email',
            'message',
            'issue',
            'phone',
        ];
}
