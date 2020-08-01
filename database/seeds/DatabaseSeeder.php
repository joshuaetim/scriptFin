<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // ComplainSeeder::class,
            // InvestmentSeeder::class,
            // SupportSeeder::class,
            AdminSeeder::class,
            ]);
    }
}
