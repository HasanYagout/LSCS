<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
{
    use HasFactory;
    protected $fillable=['cvs'];
    public function appliedJobs()
    {
        return $this->hasMany(AppliedJobs::class, 'job_id');
    }
}
