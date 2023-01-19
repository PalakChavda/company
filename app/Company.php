<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'company';
    public $timestamps = true;

    protected $fillable = [
        'name', 'email', 'password','website', 'license_no', 'address', 'country','state', 'city', 'status'
    ];

    protected $dates = ['created_at','updated_at','deleted_at'];

}
