<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tenant_id', 'notice_category_id', 'title', 'slug', 'details', 'image', 'status', 'created_by'];

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(){
        return $this->belongsTo(NoticeCategory::class, 'notice_category_id');
    }
}
