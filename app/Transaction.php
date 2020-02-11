<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ["name","description","attachment","currency","amount","categoryID","customerID","type","date","userID"];
 
    public function category()
    {
        return $this->hasOne('App\Category','id','categoryID');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer','id','customerID');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','userID');
    }
}
