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
        $userAdmin = User::find(1);
        
        Activity::factory()
            ->count(5)
            ->for($userAdmin, 'author')
            ->create([
                'allows_confirmations' => false,
            ]);

        Activity::factory()
            ->count(5)
            ->for($userAdmin, 'author')
            ->create([
                'allows_confirmations' => true,
            ]);
    }
}
