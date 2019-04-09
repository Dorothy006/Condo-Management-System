<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lendings extends Model
{
    //
    protected $fillable = ['id', 'itemName', 'borrowerName','borrowDate'];
}
