<?php

use Illuminate\Database\Seeder;

class InvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $investments = [
            [
                'user_id' => 2,
                'amount_offered' => 30000,
                'mature_date' => now()->addDays(7),
                'created_at' => new DateTime
            ],
            [
                'user_id' => 2,
                'amount_offered' => 50000,
                'mature_date' => now()->addDays(7),
                'created_at' => new DateTime
            ],
            [
                'user_id' => 3,
                'amount_offered' => 150000,
                'mature_date' => now()->addDays(7),
                'created_at' => new DateTime
            ],
            [
                'user_id' => 1,
                'amount_offered' => 10000,
                'mature_date' => now()->addDays(7),
                'created_at' => new DateTime
            ]
        ];
        
        DB::table('investments')->insert($investments);
    }
}
