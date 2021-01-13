<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/languages.json";

        $lang = json_decode(file_get_contents($path), true);


        foreach ($lang as $language) {
            $lang = new Language;
            $lang->code = $language['code'];
            $lang->name = $language['name'];
            $lang->native_name = $language['nativeName'];
            $lang->save();
        }
    }
}
