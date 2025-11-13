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
                'name' => 'administrator',
                'label' => 'Administrador',
                'description' => 'Tem acesso total ao sistema, podendo gerenciar usuários, permissões e configurações.',
            ],
            [
                'name' => 'developer',
                'label' => 'Desenvolvedor',
                'description' => 'Responsável pela manutenção e implementação de novas funcionalidades no sistema.',
            ],
            [
                'name' => 'broadcaster',
                'label' => 'Locutor',
                'description' => 'Gerencia transmissões ao vivo e interage com o público durante as programações.',
            ],
            [
                'name' => 'writer',
                'label' => 'Redator',
                'description' => 'Cria e edita artigos, notícias e demais conteúdos de texto para publicação.',
            ],
            [
                'name' => 'social_media',
                'label' => 'Social Media',
                'description' => 'Gerencia as redes sociais, produz postagens e acompanha o engajamento.',
            ],
            [
                'name' => 'marketing',
                'label' => 'Marketing',
                'description' => 'Responsável por campanhas, divulgação e estratégias de crescimento da marca.',
            ],
            [
                'name' => 'podcaster',
                'label' => 'Podcaster',
                'description' => 'Produz, edita e publica episódios de podcast na plataforma.',
            ],
        ];

        foreach($roles as $item){
            Role::create([
                'name' => $item['name'],
                'label' => $item['label'],
                'description' => $item['description'],
            ]);
        }
    }
}
