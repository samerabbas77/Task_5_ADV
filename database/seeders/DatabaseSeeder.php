<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create admin and manager account
        $this->call(CreateAdminSeeder::class);

        //creat some tasks
        $this->call(TaskSeeder::class);
    }

}
