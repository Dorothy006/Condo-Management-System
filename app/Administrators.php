<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrators extends Model
{
    protected $fillable = ['id', 'account', 'password'];    
}
