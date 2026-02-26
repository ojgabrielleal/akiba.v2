<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()
            ->count(5)
            ->for(User::find(1), 'responsible')
            ->create();

        Task::factory()
            ->count(5)
            ->for(User::find(1), 'responsible')
            ->create([
                'dead_line' => fn() => fake()->dateTimeBetween(now()->startOfWeek(), now()->endOfWeek())->format('Y-m-d')
            ]);

        Task::factory()
            ->count(5)
            ->for(User::find(1), 'responsible')
            ->create([
                'dead_line' => fn() => fake()->dateTimeBetween(now(), now()->endOfYear())->format('Y-m-d')
            ]);
    }
}
