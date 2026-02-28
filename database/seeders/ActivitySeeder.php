<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::factory()
            ->for(User::find(1), 'author')
            ->create();
            
        Activity::factory()
            ->for(User::factory()->create(), 'author')
            ->create();
    }
}
