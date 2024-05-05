<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

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

    public function comments()
    {
        return $this->hasMany(PostComment::class)->whereNull('parent_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
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
