<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
{
    use HasFactory,SoftDeletes;
    protected $fillable=['cvs','phone','status','linkedin_url','first_name','experience','education','skills','last_name','email','password','date_of_birth','about_me','image'];
    protected $dates=['deleted_at'];
    public function appliedJobs()
    {
        return $this->hasMany(AppliedJobs::class, 'alumni_id', 'student_id');
    }
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'alumni_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'alumni_id');
    }
    public function cvs()
    {
        return $this->hasMany(CV::class, 'alumni_id','student_id');
    }
    public function experience()
    {
        return $this->hasMany(Experience::class, 'alumni_id');
    }
}
