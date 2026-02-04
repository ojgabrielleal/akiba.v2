<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Program;
use App\Models\ProgramSchedule;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Program::factory()
            ->for(User::factory()->create(), 'host')
            ->has(ProgramSchedule::factory()->count(3), 'schedules')
            ->create();
    }
}
