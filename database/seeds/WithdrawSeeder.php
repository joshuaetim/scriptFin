<?php

use Illuminate\Database\Seeder;

class WithdrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $withdraws = [
            [
                'user_id' => 1,
                'amount' => 10000,
                'created_at' => now()
            ],
            [
                'user_id' => 2,
                'amount' => 10000,
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'amount' => 20000,
                'created_at' => now()
            ]
        ];

        DB::table('withdraws')->insert($withdraws);
    }
}
