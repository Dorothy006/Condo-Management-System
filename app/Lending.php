<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    //
    protected $table = 'lendings';

    public $primaryKey = 'id';

    public $timestamps = true;
}
