<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'manufacturer_name','manufacturer_desc','manufacturer_status'
    ];
    protected $primaryKey = 'manufacturer_id';
    protected $table = 'tbl_manufacturer';

    public function product(){
        return $this->hasMany('App\Models\Product');
    }
}
