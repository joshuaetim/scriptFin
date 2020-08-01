<?php

use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $donations = [
            [
                'user_id' => 2,
                'amount_offered' => 30000,
                'mature_date' => now()->addMonth(),
                'created_at' => new DateTime
            ],
            [
                'user_id' => 2,
                'amount_offered' => 50000,
                'mature_date' => now()->addMonth(),
                'created_at' => new DateTime
            ],
            [
                'user_id' => 3,
                'amount_offered' => 150000,
                'mature_date' => now()->addMonth(),
                'created_at' => new DateTime
            ],
            [
                'user_id' => 1,
                'amount_offered' => 10000,
                'mature_date' => now()->addMonth(),
                'created_at' => new DateTime
            ]
        ];
        
        DB::table('donations')->insert($donations);
    }
}
