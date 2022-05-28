<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Introduction extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'introduction_information', 'introduction_image'
    ];
    protected $primaryKey = 'introduction_id';
    protected $table = 'tbl_introduction';
}
