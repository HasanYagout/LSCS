<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;
    protected $fillable=['alumni_id','admin_id','status'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    // Relationship with Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id')->where('role_id', 4);
    }
}
