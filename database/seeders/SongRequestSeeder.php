<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;
use App\Models\Music;
use App\Models\SongRequest;

class SongRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $onair = Onair::find(2);
        $music = Music::factory()->create();

        SongRequest::factory()
            ->for($onair, 'onair')
            ->for($music, 'music')
            ->create();
    }
}
