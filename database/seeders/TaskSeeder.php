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
        $userAdmin = User::find(1);

        Task::factory()
            ->count(5)
            ->for($userAdmin, 'responsible')
            ->create();

        Task::factory()
            ->count(5)
            ->for($userAdmin, 'responsible')
            ->create([
                'deadline' => fn() => fake()->dateTimeBetween(now()->startOfWeek(), now()->endOfWeek())->format('Y-m-d')
            ]);
    }
}
