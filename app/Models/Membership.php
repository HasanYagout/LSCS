<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'membership_plans';
    protected $fillable = [
        'tenant_id',
        'title',
        'slug',
        'badge',
        'price',
        'duration_type',
        'duration',
        'status',
    ];

    public function userMembershipPlans(){
        return $this->hasMany(UserMembershipPlan::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

}
