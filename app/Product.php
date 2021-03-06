<?php

namespace App;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    //
    protected $fillable = ['product_name','price','description','barcode','category_id','product_image_url','quantity'];

    public function product_category(){
        return $this->belongsTo(ProductCategory::class,'category_id');
    }

    public function agents(){
        return $this->belongsToMany(User::class);
    }
}
