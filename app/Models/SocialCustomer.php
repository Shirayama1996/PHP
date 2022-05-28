<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SocialCustomer extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'provider_user_id',  'provider',  'user'
    ];
 
    protected $primaryKey = 'user_id';
 	  protected $table = 'tbl_social_customer';
 	
 	public function customer(){
 		return $this->belongsTo('App\Models\Customer', 'user');
 	}
 	

}
