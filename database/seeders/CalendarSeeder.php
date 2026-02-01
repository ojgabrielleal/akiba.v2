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
        $userAdmin = User::find(1);
        $activityConfirmations = Activity::where('allows_confirmations', true)->get();

        // Create event without being activity
        Calendar::factory()
            ->for($userAdmin, 'responsible')
            ->create();

        // Create event with activity
        foreach ($activityConfirmations as $activityConfirmation) {
            Calendar::factory()
                ->for($userAdmin, 'responsible')
                ->for($activityConfirmation, 'activity')
                ->create([
                    'category' => 'activity',
                    'has_activity' => true,
                ]);
        }
    }
}
