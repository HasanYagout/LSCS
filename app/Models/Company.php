<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory;
    protected $fillable=['status'];
    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');

    }
    public function appliedJobs()
    {
        return $this->hasMany(AppliedJobs::class, 'company_id');
    }

}
