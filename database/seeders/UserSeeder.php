<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\UserPreference;
use App\Models\UserSocial;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(UserPreference::factory(), 'preferences')
            ->has(UserSocial::factory(), 'socials')
            ->hasAttached(Role::where('name', 'administrator')->first(), [], 'roles')
            ->create([
                'username' => 'admin',
                'password' => 'admin',
                'name' => 'Yagami Kou',
                'nickname' => 'Yagami',
                'gender' => 'female',
            ]);
    }
}
