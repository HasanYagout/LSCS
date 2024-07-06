<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable=['is_alumni'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }
}
