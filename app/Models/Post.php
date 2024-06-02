<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    protected $fillable = [
        'tenant_id',
        'slug',
        'body',
        'status',
        'created_by'
    ];

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function creator()
    {
        if ($this->created_by === 'admin') {
            return $this->belongsTo(Admin::class, 'user_id');
        } else {
            return $this->belongsTo(Company::class, 'user_id');
        }
    }

    // Optional: Separate methods if you need to specifically fetch the type
    public function getCreatorAttribute()
    {
        return $this->created_by === 'admin' ? $this->admin : $this->company;
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(PostComment::class)->whereNull('parent_id');
    }



    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id');
    }

    function replies()
    {
        return $this->hasMany(PostComment::class);
    }
}
