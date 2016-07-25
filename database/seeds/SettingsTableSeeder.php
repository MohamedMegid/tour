<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('settings')->insert([
            'name' => 'mail',
            'options' => '{"driver": "smtp", "host": "server3.innoflame.net", "port": "465", "user_name": "customer.service@munasabaty.com", "password": "*)k2yIN}w,8y", "address":"customer.service@munasabaty.com", "name":"munasabaty", "encryption": "ssl"}'
        ]);

        DB::table('settings')->insert([
            'name' => 'social_media',
            'options' => '{"facebook": "", "twitter": ""}'
        ]);

        DB::table('settings')->insert([
            'name' => 'app-links',
            'options' => '{"apple": "", "google": ""}'
        ]);
    }
}
