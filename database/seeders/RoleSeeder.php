<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'administrador',
                'description' => 'Acesso total ao sistema'
            ],
            [
                'name' => 'desenvolvedor',
                'description' => 'Acesso ao ambiente de desenvolvimento e funcionalidades técnicas'
            ],
            [
                'name' => 'locutor',
                'description' => 'Acesso para criar e gerenciar transmissões ao vivo ou gravações'
            ],
            [
                'name' => 'redator',
                'description' => 'Acesso para criar e editar conteúdo textual'
            ],
            [
                'name' => 'social_media',
                'description' => 'Acesso para gerenciar redes sociais e publicações'
            ],
            [
                'name' => 'marketing',
                'description' => 'Acesso a ferramentas e relatórios de marketing'
            ],
            [
                'name' => 'podcaster',
                'description' => 'Acesso para criar, gerenciar e publicar podcasts'
            ],
        ];

        foreach($roles as $item){
            Role::create([
                'name' => $item['name'],
                'description' => $item['description'],
            ]);
        }
    }
}
