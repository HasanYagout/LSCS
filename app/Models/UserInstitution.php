<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInstitution extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'degree',
        'passing_year',
        'institute',
    ];
}
