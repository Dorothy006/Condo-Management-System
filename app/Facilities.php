<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    //
    protected $fillable = ['id','facility_name', 'duration', 'fee', 'facility_desc'];
}
