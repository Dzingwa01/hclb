<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $password = \Illuminate\Support\Facades\Hash::make('secret');
        $verification_time = \Carbon\Carbon::now();
        $super = User::create(['name'=>'App Admin','surname'=>'User','email'=>'admin@hlcb.co.za'
            ,'contact_number'=>'076677777','email_verified_at'=>$verification_time,'password'=>$password]);

        $super_role = Role::where('name','app-admin')->first();
        $super->roles()->attach($super_role->id);

        $location = \App\Location::where('location_name','Fort Hare')->first();
        $clerk = User::create(['name'=>'Agent','surname'=>'User','email'=>'agent@hlcb.co.za'
            ,'contact_number'=>'076677777','email_verified_at'=>$verification_time,'password'=>$password,'location_id'=>$location->id]);

        $agent_role = Role::where('name','agent')->first();
        $clerk->roles()->attach($agent_role->id);
    }
}
