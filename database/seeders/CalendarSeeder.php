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
        Calendar::factory()
            ->for(User::factory()->create(), 'responsible')
            ->create();

        Calendar::factory()
            ->for(User::find(1), 'responsible')
            ->create();

        Activity::factory()
            ->for(User::find(1), 'author')
            ->create();
        
        $confirmations = Activity::where('allows_confirmations', true)->get();

        foreach ($confirmations as $confirmation) {
            Calendar::factory()
                ->for(User::factory()->create(), 'responsible')
                ->for($confirmation, 'activity')
                ->create([
                    'type' => 'activity',
                    'has_activity' => true,
                ]);
        }
    }
}
