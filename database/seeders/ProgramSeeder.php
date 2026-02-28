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
            ->for(User::find(1), 'host')
            ->has(ProgramSchedule::factory(), 'schedules')
            ->create();        

        Program::factory()
            ->for(User::factory()->create(), 'host')
            ->has(ProgramSchedule::factory(), 'schedules')
            ->create();
    }
}
