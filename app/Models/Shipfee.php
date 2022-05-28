<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipfee extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'fee_matp', 'fee_maqh','fee_xaid','fee_shipfee'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_shipfee';

    public function city(){
        return $this->belongsTo('App\Models\City', 'fee_matp');
    }

    public function district(){
        return $this->belongsTo('App\Models\District', 'fee_maqh');
    }

    public function ward(){
        return $this->belongsTo('App\Models\Ward', 'fee_xaid');
    }
}
