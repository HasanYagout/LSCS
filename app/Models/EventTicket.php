<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'event_id',
        'user_id',
        'ticket_number',
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
