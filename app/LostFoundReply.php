<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LostFoundReply extends Model
{
    //
    protected $fillable = ['id','topicId','residentId','name','email','message','date'];

}
