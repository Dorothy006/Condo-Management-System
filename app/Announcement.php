<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    //
	protected $fillable = ['id', 'announ_desc', 'push_time','push_date'];
}
