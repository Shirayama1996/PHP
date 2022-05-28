<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'city_name', 'type'
    ];
    protected $primaryKey = 'matp';
    protected $table = 'tbl_city';
}
