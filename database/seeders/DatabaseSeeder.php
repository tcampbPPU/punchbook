<?php

namespace Database\Seeders;

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
        echo 'Factory seeder is set for ' . env('FACTORY_ROUNDS', 1) . " round(s) \n";

        $this->call([
            ContactSeeder::class,
        ]);
    }
}
