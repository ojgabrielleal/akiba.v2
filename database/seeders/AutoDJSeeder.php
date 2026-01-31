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
        $user = User::factory()->create();
        $phrases = AutoDJPhrase::factory()->count(5);

        AutoDJ::factory()
            ->for($user, 'host')
            ->has($phrases, 'phrases')
            ->create();
    }
}
