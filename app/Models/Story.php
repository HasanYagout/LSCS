<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{

    protected $fillable = [
        'posted_by',
        'title',
        'slug',
        'thumbnail',
        'body',
        'status',
    ];


    public function author(){
        return $this->belongsTo(Admin::class, 'posted_by')->withTrashed();
    }
}
