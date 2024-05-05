<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'name',
    ];

    public function event(){
        return $this->hasMany(Event::class);
    }
}
