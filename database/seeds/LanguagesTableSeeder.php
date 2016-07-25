<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => 'English',
            'code' => 'en',
            'direction' => '0',
            'main' => '1'
        ]);
        DB::table('languages')->insert([
            'name' => 'العربية',
            'code' => 'ar',
            'direction' => '1',
            'main' => '0'
        ]);        
    }
}
