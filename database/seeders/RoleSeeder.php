<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $metaadmin = new Role;
        $metaadmin->name = "metaadamin";
        $metaadmin->description = 'All permissions';
        $metaadmin->write = 1;
        $metaadmin->save();

        $superadmin = new Role;
        $superadmin->name = "superadmin";
        $superadmin->description = 'All company permissions';
        $superadmin->write = 1;
        $superadmin->save();

        $admin = new Role;
        $admin->name = "admin";
        $admin->description = 'All chapter permissions';
        $admin->write = 1;
        $admin->save();

        Role::factory(100)
            ->create();

    }
}
