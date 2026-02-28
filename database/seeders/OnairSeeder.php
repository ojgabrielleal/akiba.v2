<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\AutoDJ;
use App\Models\Program;
use App\Models\Onair;

class OnairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $auto = AutoDJ::factory()
            ->for(User::factory()->create(), 'host')
            ->create();

        $program = Program::factory()
            ->for(User::factory()->create(), 'host')
            ->create();

        Onair::factory()
            ->for($auto, 'program')
            ->create([
                'is_live' => true,
                'type' => 'auto'
            ]);

        Onair::factory()
            ->for($program, 'program')
            ->create([
                'is_live' => false,
                'type' => 'live'
            ]);
    }
}
