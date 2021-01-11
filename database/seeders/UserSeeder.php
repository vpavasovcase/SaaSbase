<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $metaadmin = new User;
        $metaadmin->name = "Vojislav Pavasović";
        $metaadmin->email = "vpavasov@gmail.com";
        $metaadmin->password = Hash::make('kjm56era');
        $metaadmin->save();

        $metaadmin->roles()->attach([1, 2, 3]);

        $metaadmin = new User;
        $metaadmin->name = "Meho Muratović";
        $metaadmin->email = "meho@gmail.com";
        $metaadmin->password = Hash::make('zidarska');
        $metaadmin->save();

        $metaadmin->roles()->attach([4]);

        User::factory(10000)
            ->has(Role::factory()->count(2))
            ->create();

        //
    }
}
