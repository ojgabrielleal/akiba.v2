<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\UserPreference;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'slug' => Str::slug('aya'),
            'username' => 'aya',
            'password' => Hash::make('aya123'),
            'name' => 'Ayasumi Sato',
            'nickname' => 'Aya',
            'gender' => 'female'
        ]);

        $preferences = [
            [
                'user_id' => $user->id,
                'is_like' => true,
                'content' => 'mahou-shojo',
            ],
            [
                'user_id' => $user->id,
                'is_like' => true,
                'content' => 'slice-of-life',
            ],
            [
                'user_id' => $user->id,
                'is_like' => true,
                'content' => 'misterio',
            ],
            [
                'user_id' => $user->id,
                'is_like' => false,
                'content' => 'esporte',
            ],
            [
                'user_id' => $user->id,
                'is_like' => false,
                'content' => 'romance',
            ],
            [
                'user_id' => $user->id,
                'is_like' => false,
                'content' => 'mecha',
            ],
        ];

        foreach($preferences as $item){
            UserPreference::create([
                'user_id' => $item['user_id'],
                'is_like' => $item['is_like'],
                'content' => $item['content']
            ]);
        }

        $role = Role::where('name', 'administrator')->first();
        $user->roles()->attach($role->id);
    }
}
