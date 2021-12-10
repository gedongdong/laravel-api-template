<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        for ($i = 1; $i <= 2; $i++) {
            DB::table('users')->insert([
                'name'     => 'user' . $i,
                'password' => bcrypt('123456'),
            ]);
            DB::table('admins')->insert([
                'name'     => 'admin' . (122 + $i),
                'password' => bcrypt('123456'),
            ]);
        }
    }
}
