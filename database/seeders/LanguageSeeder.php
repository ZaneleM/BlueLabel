<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = array(

            array('name'=>'Afrikaans'),
            array('name'=>'English'),
            array('name'=>'Northern Sotho'),
            array('name'=>'Ndebele'),
            array('name'=>'Sesotho'),
            array('name'=>'Swati'),
            array('name'=>'Tswana'),
            array('name'=>'Tsonga'),
            array('name'=>'Venda'),
            array('name'=>'Xhosa'),
            array('name'=>'Zulu'),
            array('name'=>'Other'),
        );

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
