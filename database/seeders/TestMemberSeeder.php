<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test member account
        Member::create([
            'name' => 'Test Member',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
            'image' => 'default.jpg',
            'is_active' => 1,
            'role' => 'normal'
        ]);

        // Create a manager member account
        Member::create([
            'name' => 'Manager Member',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'image' => 'default.jpg',
            'is_active' => 1,
            'role' => 'manager'
        ]);
    }
}
