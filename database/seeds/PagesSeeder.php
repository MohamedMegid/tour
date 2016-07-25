<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'published' => '1'
        ]);
        DB::table('pages_trans')->insert([
            'title' => 'من نحن',
            'body' => 'تفالصيل من نحن',
			'lang' => 'ar',
			'tid' => '1'
        ]);
		DB::table('pages_trans')->insert([
            'title' => 'About Us',
            'body' => 'About tourism project Body',
			'lang' => 'en',
			'tid' => '1'
        ]);
        DB::table('pages')->insert([
            'published' => '1'
        ]);
        DB::table('pages_trans')->insert([
            'title' => 'عن الإحساء',
            'body' => 'الإحساء مدينة جميلة في جنوب المملكة العربية السعودية',
			'lang' => 'ar',
			'tid' => '2'
        ]);
		DB::table('pages_trans')->insert([
            'title' => 'About El-Ehsaa',
            'body' => 'About El-Ehsaa details',
			'lang' => 'en',
			'tid' => '2'
        ]);
        DB::table('pages')->insert([
            'published' => '1'
        ]);
        DB::table('pages_trans')->insert([
            'title' => 'خطط لرحلتك',
            'body' => 'خطط لحلتك فقط قم بإستعراض المعالم السياحية',
			'lang' => 'ar',
			'tid' => '3'
        ]);
		DB::table('pages_trans')->insert([
            'title' => 'Arrange your journey',
            'body' => 'Arrange your journey body',
			'lang' => 'en',
			'tid' => '3'
        ]);
    }
}
