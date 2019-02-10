<?php

namespace App;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    //
    protected $fillable = ['product_name','price','description','barcode'];
}
