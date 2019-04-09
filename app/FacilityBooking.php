<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityBooking extends Model
{
    //
    protected $fillable = ['id', 'roomNumber', 'facility_name', 'duration', 'fee','facility_desc','booking_date','time_in','time_out'];
}
