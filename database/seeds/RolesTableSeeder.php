<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Visitor Role 1
        DB::table('roles')->insert([
        	'id' => '1',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '1',
            'title' => 'Visitor',
            'lang' => 'en',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '1',
            'title' => 'زائر',
            'lang' => 'ar',
        ]);
        // End Visitor Role

    	// Developer Role 2
        DB::table('roles')->insert([
        	'id' => '2',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '2',
            'title' => 'Developer',
            'lang' => 'en',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '2',
            'title' => 'المطور',
            'lang' => 'ar',
        ]);
        // End Developer Role

        // Adminstrator Role 3
        DB::table('roles')->insert([
        	'id' => '3',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '3',
            'title' => 'Adminstrator',
            'lang' => 'en',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '3',
            'title' => 'مدير النظام',
            'lang' => 'ar',
        ]);
        // End Adminstrator User Role

        // Registered User Role 4
        DB::table('roles')->insert([
        	'id' => '4',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '4',
            'title' => 'Registered User',
            'lang' => 'en',
        ]);

        DB::table('roles_trans')->insert([
            'role_id' => '4',
            'title' => 'مستخدم مسجل',
            'lang' => 'ar',
        ]);
        // End Registered User Role

        

    }
}
