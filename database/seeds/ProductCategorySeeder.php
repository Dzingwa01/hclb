<?php

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category = \App\ProductCategory::create(['category_name'=>'Food',"description"=>"General Food Stuff"]);
        $category_2 = \App\ProductCategory::create(['category_name'=>'Sanitary',"description"=>"General Sanitary Stuff"]);
    }
}
