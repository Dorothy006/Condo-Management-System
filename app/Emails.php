<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $fillable = ['id', 'name','roomId', 'email','topic','content'];
}
