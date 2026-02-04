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
            ->count(5)
            ->for(User::find(1), 'author')
            ->create([
                'allows_confirmations' => false,
            ]);

        Activity::factory()
            ->count(5)
            ->for(User::find(1), 'author')
            ->create([
                'allows_confirmations' => true,
            ]);
    }
}
