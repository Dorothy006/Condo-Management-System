<?php

namespace App\Http\Controllers;

use App\Lendings;
use App\Repairs;
use Illuminate\Http\Request;
use App\Residents;
use App\User;
use App\Announcements;
use Log;
use Session;
use Hash;
use Url;
use Illuminate\Support\Facades\Input;
use App\Visitors;
use App\Packages;
use App\LostFoundTopic;
use App\Parking;
use App\Announcement;
use App\Lending;
use App\Repair;
use App\Event;
class ConsoleController extends Controller
{

    public function error(Request $request){
        Log::notice('123');
        return view('error');
    }

    public function index(Request $request){
        if($request->session()->get('resident_id')=='-1')

            return view('index');
        else
            return redirect('error');
    }
    public function profile_update(Request $request){

        $rid=Session::get('resident_id');
        Log::notice($rid);
        $filename = Residents::where('id',$rid)->first()->photo;
        if(Input::hasFile('photo')){
            $file = Input::file('photo');
            $filename='profile_'.$rid.'.jpg';
            $file->move('images',$filename);
        }
        Residents::where('id',$rid)->update(['name' => $request->name,'email' => $request->email,
            'mobile' => $request->mobile,'phone' => $request->phone,'token'=>$request->password,'photo'=>$filename]);
        User::where('resident_id',$rid)->update(['account'=>$request->email,'password'=>Hash::make($request->password)]);
        return redirect()->route('profile', ['id' => $rid]);
    }
    public function profile(Request $request,$id){
        $rid=Session::get('resident_id');
        Log::notice($rid);
        if($request->session()->get('resident_id')>0){
            $r=Residents::leftJoin('rooms', 'residents.roomid', '=', 'rooms.id')->where('residents.id',$id)->first();
            return view('resident.profile',['resident'=>$r]);
        }else return redirect('error');
    }
    public function ui(Request $request){
        if($request->session()->get('resident_id')>0)
            return view('resident.userinterface');
        else return redirect('error');
    }
    public function console(Request $request){
        if($request->session()->get('resident_id')>0){
            $rid = $request->session()->get('resident_id');
            $resident = Residents::where('id',$rid)->first();
            $announcements = Announcements::whereDate('date','>=',date('Y-m-d'))->orderBy('date')->get();

            date_default_timezone_set("est");
            $time = date("H");

            return view('resident.userinterface',['resident'=>$resident,'announcements'=>$announcements,'time'=>$time]);return view('resident.userinterface',['resident'=>$resident,'announcements'=>$announcements,'time'=>$time,'timezome'=>$timezone]);
       }
    	else if($request->session()->get('resident_id')==-1){
        $visitors = Visitors::get()->count();
        $packages = Packages::get()->count();
        $lost = LostFoundTopic::get()->count();
        $parking = Parking::get()->count();
        $announcement = Announcement::get()->count();
        $books = Lendings::get()->count();
        $repair = Repairs::get()->count();
        $events = Event::get()->count();
        // Log::notice($visitors);
    		return view('index',['visitors'=>$visitors,'packages'=>$packages,'lost'=>$lost,'parking'=>$parking,'announcement'=>$announcement,'repair'=>$repair,'books'=>$books,'events'=>$events]);
      }
  		else return redirect('error');
    }
}
