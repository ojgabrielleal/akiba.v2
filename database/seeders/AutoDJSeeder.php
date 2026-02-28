<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\AutoDJ;
use App\Models\AutoDJPhrase;

class AutoDJSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AutoDJ::factory()
            ->for(User::factory()->create(), 'host')
            ->has(AutoDJPhrase::factory(), 'phrases')
            ->create();
    }
}
