<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassingYear extends Model
{
    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
