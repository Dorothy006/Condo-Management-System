<?php

namespace App\Http\Controllers;

use App\Residents;
use App\Rooms;
use App\Message;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Notifications\UserMessage;
use Log;
use Illuminate\Support\Facades\Session;
use Response;

class MessageController extends Controller
{
    //

    public function index(Request $request){
      if(Session::get('resident_id')>0){
           $rid = $request->session()->get('resident_id');
        Log::notice($rid);
        // $resident = Residents::where('id',$rid)->first();


        $messagesRecieved = Message::join('residents','messages.sender_id','=','residents.id')
                          ->select('messages.*','residents.name','residents.email')
                          ->where('sent_to_id',$rid)
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        $residents=Residents::join('rooms', 'residents.roomid', '=', 'rooms.id')
              ->select('residents.*', 'rooms.roomnumber')
              ->where('residents.id','!=',$rid)
              ->get();

        return view('resident.message',['residents'=>$residents,'messagesRecieved'=>$messagesRecieved]);
        }else return redirect('error');

    }



    public function send_message(Request $request)
    {

      Log::notice($request);
       $rid = $request->session()->get('resident_id');
       Log::notice($rid);
        $resident = Residents::where('id',$rid)->first();
        Log::notice($resident);


        $request->validate([
        'sentTo'=>'required|integer',
        'subject'=>'required',
        'message'=>'required'
        ]);

        $message= new Message;
        $message->sender_id=$resident->id;
        $message->sent_to_id=$request->sentTo;
        $message->subject=$request->subject;
        $message->body=$request->message;
        $message->date=date('Y-m-d H:i:s');
        $message->save();

        //get last item added to message table
        $messageId = $message->id;
        //Message::getPdo()->lastInsertId();
        $message=Message::where('id',$messageId)->first();
        $sender=$resident;


        Residents::find($request->sentTo)->notify(new UserMessage($message,$sender));

    }



    public function read(Request $request){
        //$url='';
        Log::notice($request);
        Message::where('id', $request->id)
        ->update(['read_at' => date('Y-m-d H:i:s')]);
        $message = Message::join('residents','messages.sender_id','=','residents.id')
                          ->select('messages.*','residents.name')
                          ->where('messages.id',$request->id)
                          ->get();

        return Response::json($message);

    }

    public function index_sent(Request $request){
      if(Session::get('resident_id')>0){
        $rid = $request->session()->get('resident_id');
     Log::notice($rid);
        Log::notice($rid);
        // $resident = Residents::where('id',$rid)->first();


        $messagesSent = Message::join('residents','messages.sent_to_id','=','residents.id')
                          ->select('messages.*','residents.name','residents.email')
                          ->where('sender_id',$rid)
                          ->orderBy('created_at', 'desc')
                          ->paginate(4);


        return view('resident.messagessent',['messagesSent'=>$messagesSent]);
        }else return redirect('error');

    }

}
