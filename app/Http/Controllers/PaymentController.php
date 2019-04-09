<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use Session;
use Hash;
use Url;
use App\Payment;
use App\Room;
use APP\Residents;

class PaymentController extends Controller
{
    public function index(Request $request){
        if(Session::get('resident_id')>0){
            $rid = $request->session()->get('resident_id');
            $payment = payment::join('rooms','rooms.roomnumber','=','payments.roomNumber')
                        ->join('residents','residents.roomid','=','rooms.id')
                        ->select('payments.*')
                        ->where('residents.id',$rid)
                        ->get();
            return view('resident.fee',['payment'=>$payment]);
        }else return redirect('error');

    }

    public function pay_fee(Request $request){
        Log::notice($request);
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            payment::where('id', $one)->delete();
        }

        return "Fee has been paid";
    }
}
