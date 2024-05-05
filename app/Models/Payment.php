<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'tenant_id',
        'paymentable_id',
        'paymentable_type',
        'gateway_id',
        'paymentId',
        'tnxId',
        'user_id',
        'bank_id',
        'deposit_slip',
        'sub_total',
        'tax',
        'system_currency',
        'payment_currency',
        'conversion_rate',
        'grand_total',
        'grand_total_with_conversation_rate',
        'subscription_type',
        'payment_details',
        'gateway_callback_details',
        'payment_status',
    ];

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class );
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class );
    }

    public function gateway(){
        return $this->belongsTo(Gateway::class);
    }
    public  function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }

}
