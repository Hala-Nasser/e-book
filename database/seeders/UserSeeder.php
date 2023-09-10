<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'user 1', 'email' => 'user1@gmail.com', 'password' => '123456', 'birthday' => '2000-09-07']);
        User::create(['name' => 'user 2', 'email' => 'user2@gmail.com', 'password' => '123456', 'birthday' => '2000-10-07']);
        User::create(['name' => 'user 3', 'email' => 'user3@gmail.com', 'password' => '123456', 'birthday' => '2000-09-10']);
    }
}
