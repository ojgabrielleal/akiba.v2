<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;

class OnairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $program = Program::factory()
            ->for(User::factory()->create(), 'host')
            ->create();

        Onair::factory()->create([
            'program_id' => $program->id,
            'program_type' => Program::class
        ]);
    }
}
