<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repairs;
use Illuminate\Support\Facades\Session;
use Log;

class userRepairController extends Controller
{
    //
    public function userIndex()
    {
        if(Session::get('resident_id')>0){
            $repairs =Repairs::OrderBy('repairTitle','desc')->get();
            return view('resident.repairCreate')->with('repairs',$repairs);
        }else return redirect('error');
    }

    public function add_userRepairs(Request $request){
        Log::notice('123');
        $repairs = new Repairs();
        $repairs->repairTitle=$request->repairTitle;
        $repairs->repairDetail=$request->repairDetail;
        $repairs->repairTime=$request->repairTime;
        $repairs->roomNumber=$request->roomNumber;
        $repairs->save();
    }
}
