<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    //
    protected $fillable = ['id', 'available', 'password'];
}
