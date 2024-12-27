<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) {
            Article::create([
                'title' => fake()->name(),
                'subtitle' => fake()->name(),
                'content' => fake()->text(5000),
            ]);
        }
    }
}
