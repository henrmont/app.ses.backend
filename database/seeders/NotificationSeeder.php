<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) {
            Notification::create([
                'user_id' => 1,
                'app_id' => rand(1,3),
                'title' => fake()->name(),
                'message' => fake()->name(),
            ]);
        }
    }
}
