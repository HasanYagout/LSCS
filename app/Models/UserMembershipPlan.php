<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMembershipPlan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tenant_id',
        'membership_id',
        'user_id',
        'expired_date',
        'status',
    ];

    public function membership(){
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function memberships(){
        return $this->hasMany(Membership::class, 'membership_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
