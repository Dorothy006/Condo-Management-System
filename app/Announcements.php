<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    //
    protected $fillable = ['id','announce_desc', 'time', 'date'];
}
