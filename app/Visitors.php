<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    //
    protected $fillable = ['id', 'roomNumber', 'name','email','phone','created_at','updated_at'];
}
