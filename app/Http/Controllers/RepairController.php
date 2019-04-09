<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repairs;
use Illuminate\Support\Facades\Session;
use Log;

class RepairController extends Controller
{
    public function index()
    {
        if(Session::get('resident_id')==-1){
            $repairs =Repairs::OrderBy('repairTitle','desc')->get();
            return view('admin.repair')->with('repairs',$repairs);
        }else return redirect('error');
    }



    public function add_repairs(Request $request){
        Log::notice('123');
        $repairs = new Repairs();
        $repairs->repairTitle=$request->repairTitle;
        $repairs->repairDetail=$request->repairDetail;
        $repairs->repairTime=$request->repairTime;
        $repairs->roomNumber=$request->roomNumber;
        $repairs->save();
    }



    public function update_repairs(Request $request){
        Repairs::where('id', $request->id)
            ->update(['repairTitle' => $request-> repairTitle,
                'repairDetail' => $request->repairDetail,
                'roomNumber' => $request->roomNumber,
                'repairTime' => $request->repairTime]);
        return "Repair has been updated!";
    }
    public function delete_repairs(Request $request){
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            Repairs::where('id', $one)->delete();
        }
        return "Lending has been removed!";
    }


}
