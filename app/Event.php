<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['id', 'eventTitle', 'eventDes','eventAddress','eventDate'];
}
