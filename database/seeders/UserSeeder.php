<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use ChapterUser;
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

        $companyadmin = new User;
        $companyadmin->name = "Tomislav Mišetić";
        $companyadmin->email = "tomo@gmail.com";
        $companyadmin->password = Hash::make('tomislavmisetic');
        $companyadmin->created_by = 1;
        $companyadmin->save();

        $chapteradmin = new User;
        $chapteradmin->name = "Milan Jukić";
        $chapteradmin->email = "miki@gmail.com";
        $chapteradmin->password = Hash::make('milanjukic');
        $chapteradmin->created_by = 2;
        $chapteradmin->save();

        $notadmin = new User;
        $notadmin->name = "Meho Muratović";
        $notadmin->email = "meho@gmail.com";
        $notadmin->password = Hash::make('zidarska');
        $notadmin->created_by = 3;

        $notadmin->save();

        User::factory(100)
            ->has(Role::factory()->count(2))
            ->has(Company::factory()->count(2))
            ->has(Chapter::factory()->count(3))
            ->create();

        $metaadmin->roles()->attach([1]);
        $companyadmin->roles()->attach(2);
        $chapteradmin->roles()->attach([3]);
        $notadmin->roles()->attach([4]);

        $companyadmin->companies()->attach([1, 2, 3]);
        $chapteradmin->chapters()->attach([1, 2, 3]);


        //
    }
}
