<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontendSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'page_title',
        'title',
        'slug',
        'has_page_title',
        'has_banner_image',
        'has_image',
        'has_description',
        'description',
        'banner_image',
        'image',
        'status',
    ];
}
