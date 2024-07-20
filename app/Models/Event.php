<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'event_category_id',
        'title',
        'slug',
        'thumbnail',
        'date',
        'type',
        'description',
        'user_id',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
    ];

    public function author(){
        return $this->belongsTo(Admin::class, 'posted_by')->withTrashed();
    }

    public function category(){
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }


}
