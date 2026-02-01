<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\Users;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ActivitySeeder::class,
            AutoDJSeeder::class,
            CalendarSeeder::class,
            EventSeeder::class,
            ListenerMonthSeeder::class,
            MusicSeeder::class,
            PlaylistBattleSeeder::class,
            PollSeeder::class,
            PostSeeder::class,
            PodcastSeeder::class,
            ProgramSeeder::class,
            RepositorySeeder::class,
            ReviewSeeder::class,
            SongRequestSeeder::class,
            TaskSeeder::class,
        ]);

        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
