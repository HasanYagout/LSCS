<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory;
    protected $fillable=['status','phone','image','slug','proposal','name','user_id','linkedin_url','instagram_url','facebook_url','twitter_url'];
    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');

    }
    public function appliedJobs()
    {
        return $this->hasMany(AppliedJobs::class);
    }
    public function jobs()
    {
        return $this->hasMany(JobPost::class, 'user_id', 'user_id')
            ->whereIn('posted_by', ['admin', 'company']); // Adjusted to include admin and company
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
    public function imagePath()
    {
        return asset('public/storage/company').'/' . $this->image;
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
