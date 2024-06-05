<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{

    protected  $table = 'news';

    protected $fillable = ['tenant_id', 'title', 'description', 'status'];


    public function author(){
        return $this->belongsTo(Admin::class, 'posted_by');
    }

    public function category(){
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }
}
