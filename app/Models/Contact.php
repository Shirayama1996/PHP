<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'contact_address', 'contact_map', 'contact_email', 'contact_phone', 'contact_page', 'contact_time'
    ];
    protected $primaryKey = 'contact_id';
    protected $table = 'tbl_contact';
}
