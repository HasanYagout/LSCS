<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'alumni_limit',
        'custom_domain',
        'event_limit',
        'icon_id',
        'others',
        'monthly_price',
        'yearly_price',
        'status',
        'is_default',
        'is_trail',
    ];

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function userPackage()
    {
        return $this->hasMany(UserPackage::class);
    }

}
