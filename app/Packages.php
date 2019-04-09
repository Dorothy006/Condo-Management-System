<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    //
    protected $fillable = ['id', 'roomId','packageName','packageInfo','mailboxId','mailboxPW','date','status'];

}
