<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = [
        'tenant_id',
        'name', //unique
        'slug',
        'status',
    ];

    public function news(){
        return $this->hasMany(News::class);
    }
}
