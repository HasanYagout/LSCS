<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'tenant_id',
        'title',
        'slug',
        'compensation_n_benefits',
        'salary',
        'company_logo',
        'location',
        'post_link',
        'application_deadline',
        'job_responsibility',
        'job_context',
        'educational_requirements',
        'additional_requirements',
        'employee_status',
        'status',
        'created_by',
        'updated_by'
    ];
}
