<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use SoftDeletes;
    protected $table = 'transactions';

    protected $fillable = [
        'uuid',
        'tenant_id',
        'user_id',
        'payment_id',
        'reference_id',
        'type',
        'tnxId',
        'amount',
        'purpose',
        'payment_time',
        'payment_method'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
