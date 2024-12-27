<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'is_valid' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ])->givePermissionTo('super admin');

        User::create([
            'name' => 'Tester',
            'email' => 'test@teste.com',
            'is_valid' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ])->givePermissionTo('user');

        $this->call([
            NotificationSeeder::class,
            ArticleSeeder::class,
            ChatSeeder::class
        ]);
    }
}
