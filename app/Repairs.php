<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repairs extends Model
{
    //
    protected $fillable = ['id', 'repairTitle', 'repairDetail','roomNumber','repairTime'];
}
