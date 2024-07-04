<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJobs extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id', 'student_id');
    }

    public function cv()
    {
        return $this->belongsTo(CV::class, 'cv_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}
