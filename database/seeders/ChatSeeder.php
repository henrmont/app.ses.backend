<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chat = Chat::create([
            'person_one_id' => 1,
            'person_two_id' => 2,
            'person_one_typing' => false,
            'person_two_typing' => false,
            'pending' => true
        ]);

        for ($i = 0; $i < 50; $i++) {
            ChatMessage::create([
                'chat_id' => $chat->id,
                'user_id' => fake()->randomElement([$chat->person_one_id,$chat->person_two_id]),
                'message' => fake()->text(20),
            ]);
        }
    }
}
