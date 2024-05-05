<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeCategory extends Model
{
    protected $fillable = [
        'tenant_id',
        'name', //unique
        'slug',
        'status',
    ];

    public function notice(){
        return $this->hasMany(Notice::class);
    }
}
