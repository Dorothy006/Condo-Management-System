<?php

namespace App;

use App\Residents;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['id','sender_id','sent_to_id','body','subject','date'];


}
