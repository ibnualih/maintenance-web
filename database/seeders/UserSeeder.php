<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        if(!$user){
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'handphone' => '085787449438',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
        ]);
        }
        // User::create([
        //     'name' => 'mekanik',
        //     'email' => 'mekanik@gmail.com',
        //     'handphone' => '08997566237',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('ibnu'),
        // ]);
        // User::create([
        //     'name' => 'supervisor',
        //     'email' => 'supervisor@gmail.com',
        //     'handphone' => '08997566238',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('321'),
        // ]);

    }
}
