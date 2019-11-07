<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ["name","type"];


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'categoryID');
    }
}
