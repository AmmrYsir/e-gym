<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ammar',
            'email' => 'ammaryasir03062000@gmail.com',
            'password' => Hash::make('AmmarYasir'),
            'rank' => 1
        ]);

        User::create([
            'name' => 'Ammar',
            'email' => 'ammaryasir03062001@gmail.com',
            'password' => Hash::make('AmmarYasir'),
            'rank' => 0
        ]);
    }
}