<?php

namespace App;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends BaseModel
{
    //
    protected $fillable = ['category_name','description'];

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }
}
