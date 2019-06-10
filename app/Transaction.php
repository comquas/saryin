<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ["name","description","attachment","currency","amount","categoryID","customerID","type","date"];
 
    public function category()
    {
        return $this->hasOne('App\Category','id','categoryID');
    }

    public function customer()
    {
        return $this->hasOne('App\Category','id','customerID');
    }
}
