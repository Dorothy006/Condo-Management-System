<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Session;
use Log;

class EventController extends Controller
{

    public function index()
    {
        //
        if(Session::get('resident_id')==-1){
            $events =Event::OrderBy('eventTitle','desc')->paginate();
            return view('admin.event')->with('events',$events);
        }else return redirect('error');
    }



    public function add_event(Request $request){
        Log::notice('123');
        $events = new Event();
        $events->eventTitle=$request->eventTitle;
        $events->eventDes=$request->eventDes;
        $events->eventAddress=$request->eventAddress;
        $events->eventDate=$request->eventDate;
        $events->save();
    }

    public function update_event(Request $request){
        Event::where('id', $request->id)
            ->update(['eventTitle' => $request-> eventTitle,
                'eventDes' => $request->eventDes,
                'eventAddress' => $request->eventAddress,
                'eventDate' => $request->eventDate]);

        return "Event has been updated!";
    }

    public function delete_event(Request $request){
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            Event::where('id', $one)->delete();
        }
        return "Event has been removed!";
    }
}
