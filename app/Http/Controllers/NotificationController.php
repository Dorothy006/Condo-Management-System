<?php

namespace App\Http\Controllers;

use App\Residents;
use App\Rooms;
use App\Message;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\UserMessage;
use Log;

class NotificationController extends Controller
{
    //

    public function read_noti($id){

      DatabaseNotification::where('id',$id)
      ->update(['read_at'=> date('Y-m-d')]);
      return redirect('console');


    }



}
