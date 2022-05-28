<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'product_name', 'category_id', 'manufacturer_id', 'product_desc', 'product_content', 'product_price', 'product_image', 'product_status'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function category(){
        return $this->belongsTo('App\Models\ProductCategory','category_id');
    }

    public function manufacturer(){
        return $this->belongsTo('App\Models\Manufacturer','manufacturer_id');
    }
}
