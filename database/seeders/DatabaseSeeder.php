<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Task::factory(50)->create();
        Group::factory(10)->create();

        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'reuss@gmail.com',
           'password' => Hash::make('00000000')
        ]);
    }
}
