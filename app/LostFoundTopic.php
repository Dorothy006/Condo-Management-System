<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LostFoundTopic extends Model
{
    //
    protected $fillable = ['id','residentId','name','email','subject','message','date'];

}
