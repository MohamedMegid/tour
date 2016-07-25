<?php

use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_info')->insert([
            'title' => 'YOUR TITLE HERE',
            'mail' => 'email@example.com',
        ]);

        DB::table('contact_us_phones')->insert([
            'contact_id' => '1',
            'phone' => '966521511255',
            'counter' => '1'
        ]);

        DB::table('gmap')->insert([
            'address' => 'address here',
            'latitude' => '30.11130062746564',
            'longitude' => '31.34569478034973'
        ]);
    }
}
