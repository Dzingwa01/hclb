<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $location = Location::create(['location_name'=>'Fort Hare','city'=>'East London','description'=>'university students']);
        $location_2 = Location::create(['location_name'=>'Walter Sisulu','city'=>'Mthatha','description'=>'university students']);
    }
}
