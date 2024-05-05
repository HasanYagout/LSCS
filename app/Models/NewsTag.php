<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model
{
    protected $fillable = [
        'tenant_id',
        'name', //unique
        'slug',
    ];

    public function news(){
        return $this->belongsToMany(News::class, 'news_tag', 'tag_id');
    }
}
