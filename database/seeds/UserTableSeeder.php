<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'tour@innoflame.net.sa',
            'phone' => '201002211824',
            'password' => bcrypt('INNO_tour@2015'),
            'confirmed'=>'1',
            'active'=>'1'
        ]);

        DB::table('users_roles')->insert([
            'role_id' => '3',
            'user_id'=>'1'
        ]);
    }
}
