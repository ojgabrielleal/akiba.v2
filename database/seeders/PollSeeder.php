<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Poll;
use App\Models\PollOption;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poll::factory()
            ->has(PollOption::factory()->count(3), 'options')
            ->create();
    }
}
