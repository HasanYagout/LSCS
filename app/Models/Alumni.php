<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
{
    use HasFactory;
    protected $fillable=['cvs','first_name','experience','education','skills','last_name','email','password','date_of_birth','about_me','image'];
    public function appliedJobs()
    {
        return $this->hasMany(AppliedJobs::class, 'job_id');
    }
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'alumni_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'alumni_id');
    }
    public function experience()
    {
        return $this->hasMany(Experience::class, 'alumni_id');
    }
}
