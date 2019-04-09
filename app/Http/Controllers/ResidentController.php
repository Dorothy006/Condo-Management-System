<?php

namespace App\Http\Controllers;
use App\Residents;
use App\Rooms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use Mail;
use Hash;
use App\Mail\VerifyNewUser; 
use Illuminate\Support\Facades\Session;
class ResidentController extends Controller
{
    //
    public function index(){
        if(Session::get('resident_id')==-1){
            $residents=Residents::orderby('roomid','asc')->get();
            $users = User::where('resident_id','0')->first();
            $rooms=Rooms::get();
            return view('admin.resident',['residents'=>$residents,'rooms'=>$rooms]);
        }else return redirect('error');
    }
    public function room(){
        if(Session::get('resident_id')==-1){
            $rooms=Rooms::get();
            foreach ($rooms as $room) {
                $count=Residents::where('roomid',$room->id)->count();
                $room->residents=$count;
            }
            return view('admin.room',['rooms'=>$rooms]);
        }else return redirect('error');
    }
    public function add_resident(Request $request){
        // Log::notice($request);
    	$resident = Residents::where('email',$request->email)->first();
        $user = User::where('account',$request->email)->first();
        if($user!==null || $resident!=null){//this email is already been used
            return "exist";
        }else{
            $resident = new Residents;
            $resident->token=Str::random(8);
            $resident->name=$request->name;
            $resident->roomid=$request->roomid;
            $resident->email=$request->email;
            $resident->mobile=$request->mobile;
            $resident->phone=$request->phone;
            $resident->save();
        }
    }
    public function update_resident(Request $request){
        if(User::where('resident_id',$request->id)->first()!=null)
            User::where('resident_id',$request->id)->update(['account'=>$request->email]);
        Residents::where('id', $request->id)
          ->update(['name' => $request->name,'roomid' => $request->roomid,'email' => $request->email,
            'mobile' => $request->mobile,'phone' => $request->phone]);
    }
    public function delete_resident(Request $request){
        Log::notice($request);
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            Residents::where('id', $one)->delete();
            User::where('resident_id',$one)->delete();

        }
        return "Residents has been remove.";
    }


    public function add_room(Request $request){
        $room = new Rooms;
        $room->roomnumber=$request->roomnumber;
        $room->size=$request->size;
        $room->save();

    }
    public function update_room(Request $request){
        Log::notice($request);
        Rooms::where('id', $request->id)
          ->update(['roomnumber' => $request->roomnumber,'size' => $request->size]);
        //return "hello";
    }
    public function user_registration($id,$token){
        $url='';
        $resident=Residents::where('id',$id)->first();
        $resident->isaccess=-1;//-1 => user account is created successfully
        $resident->save();
        $user = new User();
        $user->account=$resident->email;
        $user->password=Hash::make($token);
        $user->resident_id=$id;
        $user->save();
        return redirect('login');
    }
    public function registration_email(Request $request){
        $resident=Residents::where('id',$request->id)->first();
        Log::notice($resident);
        $resident->isaccess=1; //1 => email is sent but user account has not created yet
        $resident->save();
        // Log::notice($request);
        set_time_limit(60);
        Mail::to($resident->email)->send(new VerifyNewUser($resident));
        return 'Email sending success';
    }
    
    public function delete_room(Request $request){
        // Log::notice($request->all());
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            $count=Residents::where('roomid',$one)->count();
            if($count==0)
            Rooms::where('id', $one)->delete(); 
            else{
                Log::notice("!=0");
                return "This room is on use";
            } 
        }
    }
}
