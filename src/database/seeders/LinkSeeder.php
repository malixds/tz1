<?php

namespace Database\Seeders;

use App\Models\Link;
use Database\Factories\LinkFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private array $dates = ['2023-01-01 12:00:00', '2024-10-03 12:00:00'];
    public function run(): void
    {
        Link::factory()->create([
            "url" => "vk.com",
            "hash" => "maxim",
            "created_at" => $this->dates[1],
        ]);
        Link::factory()->create([
            "url" => "ok.ru",
            "hash" => "hello",
            "created_at" => $this->dates[0],
        ]);

    }
}
