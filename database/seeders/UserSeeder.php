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
        $preference = UserPreference::factory();
        $social = UserSocial::factory();
        $roles = Role::where('name', 'administrator')->first();

        // Create admin user
        User::factory()
            ->has($preference, 'preferences')
            ->has($social, 'socials')
            ->hasAttached($roles, [], 'roles')
            ->create([
                'username' => 'admin',
                'password' => 'admin',
                'name' => 'Yagami Kou',
                'nickname' => 'Yagami',
                'gender' => 'female',
            ]);
    }
}
