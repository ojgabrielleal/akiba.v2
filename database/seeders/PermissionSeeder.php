<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $permissions = [

            /*
            |--------------------------------------------------------------------------
            | 👤 Usuários
            |--------------------------------------------------------------------------
            */
            ['name' => 'user.list', 'label' => 'Listar membros'],
            ['name' => 'user.view', 'label' => 'Visualizar membro'],
            ['name' => 'user.create', 'label' => 'Cadastrar membro'],
            ['name' => 'user.update', 'label' => 'Atualizar membro'],
            ['name' => 'user.deactivate', 'label' => 'Desativar membro'],
            ['name' => 'user.update.password', 'label' => 'Atualizar senha de membro'],
            ['name' => 'user.update.permissions', 'label' => 'Atualizar permissões de membro'],
            ['name' => 'user.view.own', 'label' => 'Visualizar próprio perfil'],
            ['name' => 'user.update.own', 'label' => 'Atualizar próprio perfil'],

            /*
            |--------------------------------------------------------------------------
            | 📝 Posts
            |--------------------------------------------------------------------------
            */
            ['name' => 'post.list', 'label' => 'Listar posts'],
            ['name' => 'post.view', 'label' => 'Visualizar post'],
            ['name' => 'post.create', 'label' => 'Criar post'],
            ['name' => 'post.update', 'label' => 'Atualizar post'],
            ['name' => 'post.delete', 'label' => 'Excluir post'],
            ['name' => 'post.view.own', 'label' => 'Visualizar próprios posts'],
            ['name' => 'post.update.own', 'label' => 'Atualizar próprios posts'],

            /*
            |--------------------------------------------------------------------------
            | ⭐ Reviews
            |--------------------------------------------------------------------------
            */
            ['name' => 'review.list', 'label' => 'Listar reviews'],
            ['name' => 'review.view', 'label' => 'Visualizar review'],
            ['name' => 'review.create', 'label' => 'Criar review'],
            ['name' => 'review.update', 'label' => 'Atualizar review'],
            ['name' => 'review.delete', 'label' => 'Excluir review'],
            ['name' => 'review.view.own', 'label' => 'Visualizar próprio review'],
            ['name' => 'review.update.own', 'label' => 'Atualizar próprio review'],

            /*
            |--------------------------------------------------------------------------
            | 📺 Programas
            |--------------------------------------------------------------------------
            */
            ['name' => 'program.list', 'label' => 'Listar programas'],
            ['name' => 'program.view', 'label' => 'Visualizar programa'],
            ['name' => 'program.create', 'label' => 'Criar programa'],
            ['name' => 'program.update', 'label' => 'Atualizar programa'],
            ['name' => 'program.delete', 'label' => 'Excluir programa'],
            ['name' => 'program.view.own', 'label' => 'Visualizar próprios programas'],
            ['name' => 'program.update.own', 'label' => 'Atualizar próprios programas'],

            /*
            |--------------------------------------------------------------------------
            | 🎵 Pedidos musicais
            |--------------------------------------------------------------------------
            */
            ['name' => 'song-request.list', 'label' => 'Listar pedidos musicais'],
            ['name' => 'song-request.view', 'label' => 'Visualizar pedido musical'],
            ['name' => 'song-request.mark-played', 'label' => 'Marcar pedido como tocado'],

            /*
            |--------------------------------------------------------------------------
            | 📅 Agenda / Calendário
            |--------------------------------------------------------------------------
            */
            ['name' => 'calendar-event.list', 'label' => 'Listar eventos da agenda'],
            ['name' => 'calendar-event.view', 'label' => 'Visualizar evento da agenda'],
            ['name' => 'calendar-event.create', 'label' => 'Criar evento na agenda'],
            ['name' => 'calendar-event.update', 'label' => 'Atualizar evento da agenda'],
            ['name' => 'calendar-event.delete', 'label' => 'Excluir evento da agenda'],
            ['name' => 'calendar-event.view.own', 'label' => 'Visualizar próprios eventos'],
            ['name' => 'calendar-event.update.own', 'label' => 'Atualizar próprios eventos'],

            /*
            |--------------------------------------------------------------------------
            | 🧩 Cargos (Roles)
            |--------------------------------------------------------------------------
            */
            ['name' => 'role.list', 'label' => 'Listar cargos'],
            ['name' => 'role.view', 'label' => 'Visualizar cargo'],
            ['name' => 'role.create', 'label' => 'Criar cargo'],
            ['name' => 'role.update', 'label' => 'Atualizar cargo'],
            ['name' => 'role.delete', 'label' => 'Excluir cargo'],

            /*
            |--------------------------------------------------------------------------
            | 🔐 Permissões
            |--------------------------------------------------------------------------
            */
            ['name' => 'permission.list', 'label' => 'Listar permissões'],
            ['name' => 'permission.view', 'label' => 'Visualizar permissão'],
        ];
        
        foreach($permissions as $item){
            Permission::create([
                'label' => $item['label'],
                'name' => $item['name']
            ]);
        }

    }
}
