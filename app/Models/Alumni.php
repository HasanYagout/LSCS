<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumnus';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'batch_id',
        'department_id',
        'passing_year_id',
        'id_number',
        'company',
        'company_designation',
        'company_address',
        'file',
        'blood_group',
        'date_of_birth',
        'gender',
        'about_me',
        'linkedin_url',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'city',
        'state',
        'zip',
        'country',
        'address'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
