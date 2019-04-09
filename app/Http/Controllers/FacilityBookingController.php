<?php

namespace App\Http\Controllers;

use App\Facilities;
use App\FacilityBooking;
use App\Payment;
use App\Rooms;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;
use Illuminate\Support\Str;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Scalar\String_;

class FacilityBookingController extends Controller
{
    //
    public function index(Request $request){
        if(Session::get('resident_id')>0){
            $rid = $request->session()->get('resident_id');
            $facility_booking = FacilityBooking::get();
            $facilities = Facilities::get();
            $rooms=Rooms::join('residents','residents.roomid','=','rooms.id')
                        ->select('rooms.*')
                        ->where('residents.id',$rid)
                        ->get();
        return view('resident.facility_booking',['facility_booking'=>$facility_booking, 'facilities'=>$facilities, 'rooms'=>$rooms]);
        }else return redirect('error');
    }

    public function add_facility_booking(Request $request){
        $facilities = Facilities:: where('facility_name',$request->facility_name)->get();
        $fee = 0;
        $duration = 0;
        $facility_desc = '';
        $roomNumber=0;

        $rid = $request->session()->get('resident_id');
        $rooms=Rooms::join('residents','residents.roomid','=','rooms.id')
            ->select('rooms.*')
            ->where('residents.id',$rid)
            ->get();

        foreach ($rooms as $one){
            $roomNumber = $one->roomnumber;
        }

        foreach($facilities as $one){
            $duration = $one -> duration;
            $fee = $one -> fee;
            $facility_desc = $one -> facility_desc;
        }

        $facility_booked = FacilityBooking::get();

        $reqtime=$request->time_in;
        $requiretime=Carbon::parse($reqtime)->format('H:i:s');

        if($request->booking_date <= Carbon::today()){
            return "You can not book anything before current date";
        }

        foreach ($facility_booked as $one) {
            if ($one->facility_name == $request->facility_name && $one->booking_date == $request->booking_date &&
                $one->time_in == $requiretime) {
                $errormessage="The facility is already booked for this time slot, please select another time";
                return $errormessage;
            }
        }

            $facility_booking = new FacilityBooking();
            $payment = new Payment();
            $facility_booking->roomNumber = $roomNumber;
            $facility_booking->facility_name = $request->facility_name;
            $facility_booking->duration = $duration;
            $facility_booking->fee = $fee;
            $facility_booking->facility_desc = $facility_desc;
            $facility_booking->booking_date = $request->booking_date;
            $facility_booking->time_in = $request->time_in;
            $ajust_time = $this->addMinutesToTime($request->time_in, $duration * 60);
            $facility_booking->time_out = $ajust_time;

            $payment->roomNumber = $roomNumber;
            $des =(string)$request->facility_name;
            $des = $des.(string)$request->booking_date;
            $payment->des = $des;
            $payment->fees = $fee;
            $facility_booking->save();
            $payment->save();
            return "This booking is successfully booked";
    }

    public function delete_facility_booking(Request $request){
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            FacilityBooking::where('id', $one)->delete();
        }
        return "This booking has been removed!";
    }

    function addMinutesToTime( $time, $plusMinutes ) {
        $time = DateTime::createFromFormat( 'g:i', $time );
        $time->add( new DateInterval( 'PT' . ( (double) $plusMinutes ) . 'M' ) );
        $newTime = $time->format( 'g:i' );
        return $newTime;
    }
    
}
