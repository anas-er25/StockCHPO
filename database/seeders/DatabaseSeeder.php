<?php

namespace Database\Seeders;

use App\Models\Hopital;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        Hopital::insert([
            [
                'id' => 1,
                'name' => 'Sidi Hssain Bennaceur',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Bougafer',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);


        $this->call(ServicesTableSeeder::class);
    }
}