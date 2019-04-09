<?php
/**
 * Created by PhpStorm.
 * User: mshao
 * Date: 2018-11-01
 * Time: 9:35 PM
 */

namespace App\Http\Controllers;
use App\Notifications\visitorNotification;
use App\Residents;
use App\Visitors;
use App\Rooms;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class VisitorController extends Controller
{
    public function index(){
        if(Session::get('resident_id')==-1){
//            $visitors=Visitors::orderby('id','asc')->get();

            $visitors = DB::select(DB::raw("SELECT *,updated_at - created_at as last_time
                              FROM `visitors` "));
            Log::notice($visitors);

            $rooms=Rooms::get();

            return view('admin.visitor',['visitors'=>$visitors,'rooms'=>$rooms]);
        }else return redirect('error');

    }

    public function searchVisitor(Request $request){

        if($request->searchBy == "name"){
            $visitor = Visitors::where('name',$request->searchKey)->get();
        }else if($request->searchBy == "email"){
            $visitor = Visitors::where('email',$request->searchKey)->get();
        }else {
            $visitor = Visitors::where('phone',$request->searchKey)->get();
        }
//            $visitor = Visitors::where('date',$request->searchKey)->get();
//        }
        $all = Array();
        foreach($visitor as $one){
        $arr=array('0'=>$one->name,'1'=>$one->email,'2'=>$one->phone,'3'=>$one->roomNumber
            ,'4'=>Carbon::createFromFormat('Y-m-d H:i:s', $one->created_at)->toDateTimeString());
        array_push($all,$arr);
        }
        return $all;
    }

    // for user side

    public function logIn(){
        if(Session::get('resident_id')==-1){
            $rooms=Rooms::get();

            return view('admin.visitorLogIn',['rooms'=>$rooms]);
        }else return redirect('error');
    }
    public function verifyVisitorTrue($id,$name,$email,$phone,$roomNumber){
        DatabaseNotification::where('id',$id)
            ->update(['read_at'=> date('Y-m-d')]);

//        $array=Hash::make($visitor);
//        $array = serialize($visitor);
//        $array = parse_url($visitor);

        $v = new visitors;
        $v->name=$name;
        $v->email=$email;
        $v->phone=$phone;
        $v->roomNumber=$roomNumber;
        $v->save();

//        return view('resident.Myvisitor');
//            ->action('VisitorController@addVisitor',['visitor'=>$v,'email'=>$email,'phone'=>$phone,'roomNumber'=>$roomNumber]);
//            ->with('status','allowed');
//        ->route('addVisitor');

        return redirect('console');
    }

    public function verifyVisitorFalse($id){

        DatabaseNotification::where('id',$id)
            ->update(['read_at'=> date('Y-m-d')]);
        $status = 'refused';

        return redirect('console');
    }
//    admin side
    public function sendVisitorNotification(Request $request){
//        Log::notice($request);
        $newVisitor = new Visitors;
        $newVisitor->name=$request->name;
        $newVisitor->email=$request->email;
        $newVisitor->phone=$request->phone;
        $newVisitor->roomNumber=$request->roomid;

        Log::notice($request->roomid);

        $fingResidentById=Residents::where('roomid',$request->roomid)->first();
        Log::notice($fingResidentById);

        Residents::find($fingResidentById->id)->notify(new visitorNotification($newVisitor));

        return $newVisitor;

    }
    public function myVisitorList(){
        if(Session::get('resident_id')>0){

            $residentId=Session::get('resident_id');
            //get resident by id
            $resident=Residents::where('id',$residentId)->first();
            //get the visitorsList of this resident
            $myVisitors=Visitors::where('roomNumber',$resident->roomid)->get();

            $selectedVisitors = Array();
            foreach($myVisitors as $one){
                if($one->created_at == $one->updated_at){
                    $visitorArr=array('0'=>$one->id,'1'=>$one->name,'2'=>$one->email,'3'=>$one->phone,
                    '4'=>Carbon::createFromFormat('Y-m-d H:i:s', $one->created_at)->toDateTimeString());
                    array_push($selectedVisitors,$visitorArr);
                }
            }
//            Log::notice($selectedVisitors);

            return view('resident.Myvisitor',['myVisitors'=>$selectedVisitors]);
        }else return redirect('error');
    }
    public function logOut(Request $request){

        if(Session::get('resident_id')>0){
            $id=$request->id;
            Visitors::where('id',$id)
                ->update(['updated_at' => new DateTime()]);
//                    DateTime::getTimestamp()]);
        }else return redirect('error');
    }

}
