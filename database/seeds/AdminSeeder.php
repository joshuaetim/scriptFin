<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                'fullname' => 'Test User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'super' => true,
                'created_at' => new DateTime
            ]
        ];

        DB::table('admins')->insert($admin);
    }
}
