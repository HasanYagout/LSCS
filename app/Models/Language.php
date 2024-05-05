<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'language',
        'iso_code',
        'flag_id',
        'rtl',
        'status',
        'default',
        'font',
    ];

    public function getFlagAttribute()
    {
       return getFileUrl($this->flag_id);
    }
}
