<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tenant_id',
        'event_category_id',
        'title',
        'slug',
        'thumbnail',
        'date',
        'type',
        'location',
        'price',
        'number_of_ticket',
        'number_of_ticket_left',
        'description',
        'user_id',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
    ];

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function eventTicket(){
        return $this->hasMany(EventTicket::class);
    }
}
