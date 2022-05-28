<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'category_name','category_desc','category_status'
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_product_category';

    public function product(){
        return $this->hasMany('App\Models\Product');
    }
}
