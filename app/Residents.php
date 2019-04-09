<?php

namespace App;

use App\Message;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;


class Residents extends Model
{
    //
    protected $fillable = ['id', 'name', 'roomid','phone','mobile','email','isaccess','token','photo'];

    use Notifiable;


}
