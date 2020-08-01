<?php

use Illuminate\Database\Seeder;

class ComplainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $complains = [
            [
                'user_id' => 1,
                'title' => 'Scam payment made to me',
                'description' => 'I have problems when I try to login to my computer system',
                'created_at' => new DateTime
            ],
            [
                'user_id' => 1,
                'title' => 'User refused to match well',
                'description' => 'I have problems when I try to login to my computer system',
                'created_at' => new DateTime
            ],
            [
                'user_id' => 2,
                'title' => 'Trouble in correcting payment',
                'description' => 'I cant correct the payment details on my account',
                'created_at' => new DateTime
            ],
            [
                'user_id' => 3,
                'title' => 'Another Problems in my database',
                'description' => 'I have problems when I try to login to my computer system',
                'created_at' => new DateTime
            ],
        ];

        DB::table('complains')->insert($complains);
    
    }
}
