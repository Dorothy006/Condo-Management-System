<?php

namespace App\Http\Controllers;
use App\Residents;
use Illuminate\Http\Request;
use App\Mail\sendMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendEmailController extends Controller
{
    public function index(){
        if(Session::get('resident_id')==-1){
            $residents=Residents::orderby('roomid','asc')->get();
            return view ('admin.sendEmail',['residents'=>$residents]);
        }else return redirect('error');
    }

    public function sendMessage(Request $request){
        $address=$request->select_resident;
        $topic = $request->message_topic;
        $content=$request->message_content;

        foreach($address as $one) {
            Mail::to($one)->send(new sendMail($topic, $content));
        }
        return 'email send';
    }
}
