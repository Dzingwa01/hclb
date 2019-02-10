<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $super_admin = [
            'super-delete' => true,
            'super-add' => true,
            'super-update' => true,
            'super-view' => true,
        ];

        $agent_permissions = [
            'clerk-delete' => true,
            'clerk-add' => true,
            'clerk-update' => true,
            'clerk-view' => true,
        ];


        $super_user = Role::create([
            'name' => 'app-admin',
            'display_name'=>'App Admin',
            'permissions' =>$super_admin,
            'guard_name'=>'web'
        ]);

        $agent = Role::create([
            'name' => 'agent',
            'display_name'=>'Agent',
            'permissions' =>$agent_permissions,
            'guard_name'=>'web'
        ]);

    }
}
