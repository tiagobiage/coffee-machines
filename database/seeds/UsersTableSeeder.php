<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Alice Wonders',
            'email' => 'coffee@alicewonders.ws',
            'password' => bcrypt('administrator'),
        ]);
    }
}
