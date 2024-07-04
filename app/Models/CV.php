<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use HasFactory;
    protected $fillable=['alumni_id','name','slug'];
    public function appliedJobs()
    {
        return $this->hasMany(AppliedJobs::class, 'cv_id');
    }
}
