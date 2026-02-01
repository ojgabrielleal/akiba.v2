<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Activity;
use App\Models\Calendar;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $activity = Activity::factory()
            ->for($user, 'author')
            ->create();
        
        // Create event without being activity
        Calendar::factory()
            ->for($user, 'responsible')
            ->create();

        // Create event with activity
        Calendar::factory()
            ->for($user, 'responsible')
            ->for($activity, 'activity')
            ->create([
                'has_activity' => true,
            ]);
    }
}
