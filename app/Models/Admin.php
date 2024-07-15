<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable=['first_name','last_name','phone','role_id','status','email','password','image'];

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');

    }
    public function imagePath()
    {
        return asset('public/storage/admin').'/' . $this->image;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }


    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'admin_id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
