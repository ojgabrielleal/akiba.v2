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
        ->for(User::find(1), 'responsible')
        ->create();
        
        $confirmations = Activity::where('allows_confirmations', true)->get();
        foreach ($confirmations as $confirmation) {
            Calendar::factory()
                ->for(User::find(1), 'responsible')
                ->for($confirmation, 'activity')
                ->create([
                    'category' => 'activity',
                    'has_activity' => true,
                ]);
        }
    }
}
