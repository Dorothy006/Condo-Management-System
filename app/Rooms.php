<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    //
    protected $fillable = ['id', 'roomnumber', 'size','status','residents'];
}
