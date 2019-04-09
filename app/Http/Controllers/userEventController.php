<?php

namespace App\Http\Controllers;
use App\Event;
use Illuminate\Support\Facades\Session;
use Log;
use Illuminate\Http\Request;

class userEventController extends Controller
{
    //
    public function userIndex()
    {
        //
        if(Session::get('resident_id')>0){
            $events =Event::OrderBy('eventTitle','desc')->paginate();
            return view('resident.userEvent')->with('events',$events);
        }else return redirect('error');
    }
}
