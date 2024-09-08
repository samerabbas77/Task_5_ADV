<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins =[
                    [
                    "name"=> "admin",
                    "email"=> "admin@gmail.com",
                    "password"=> bcrypt("11111111"),
                    'role'    =>'admin'
                    ],
                    [  
                        "name"=> "manager",
                        "email"=> "manager@gmail.com",
                        "password"=> bcrypt("11111111"),
                        'role'  => 'manager'
                    ]
                ];
        foreach($admins as $admin)        
        User::create($admin) ;       


    }
}
