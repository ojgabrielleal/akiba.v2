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
            // 🔹 Usuários
            ['name' => 'can_list_users', 'label' => 'Listar membros'],
            ['name' => 'can_view_user', 'label' => 'Visualizar um membro específico'],
            ['name' => 'can_create_user', 'label' => 'Cadastrar um membro novo'],
            ['name' => 'can_deactivate_user', 'label' => 'Desativar um membro específico'],
            ['name' => 'can_update_user_password', 'label' => 'Atualizar senha de um membro específico'],
            ['name' => 'can_update_user_permissions', 'label' => 'Atualizar permissões de um membro específico'],
            ['name' => 'can_view_own_user', 'label' => 'Visualizar o próprio perfil'],
            ['name' => 'can_update_own_user', 'label' => 'Atualizar o próprio perfil'],

            // 🔹 Posts
            ['name' => 'can_list_posts', 'label' => 'Listar posts'],
            ['name' => 'can_view_post', 'label' => 'Visualizar um post específico'],
            ['name' => 'can_create_post', 'label' => 'Criar novo post'],
            ['name' => 'can_update_post', 'label' => 'Atualizar um post específico'],
            ['name' => 'can_delete_post', 'label' => 'Excluir um post específico'],
            ['name' => 'can_view_own_post', 'label' => 'Visualizar seus próprios posts'],
            ['name' => 'can_update_own_post', 'label' => 'Atualizar seus próprios posts'],

            // 🔹 Reviews
            ['name' => 'can_list_reviews', 'label' => 'Listar reviews'],
            ['name' => 'can_view_review', 'label' => 'Visualizar um review específico'],
            ['name' => 'can_create_review', 'label' => 'Criar um novo review'],
            ['name' => 'can_update_review', 'label' => 'Atualizar um review específico'],
            ['name' => 'can_delete_review', 'label' => 'Excluir um review específico'],
            ['name' => 'can_view_own_review', 'label' => 'Visualizar seu próprio review'],
            ['name' => 'can_update_own_review', 'label' => 'Atualizar seu próprio review'],

            // 🔹 Programas
            ['name' => 'can_list_programs', 'label' => 'Listar programas'],
            ['name' => 'can_view_program', 'label' => 'Visualizar um programa específico'],
            ['name' => 'can_create_program', 'label' => 'Criar um novo programa'],
            ['name' => 'can_update_program', 'label' => 'Atualizar um programa específico'],
            ['name' => 'can_delete_program', 'label' => 'Excluir um programa específico'],
            ['name' => 'can_view_own_program', 'label' => 'Visualizar seus próprios programas'],
            ['name' => 'can_update_own_program', 'label' => 'Atualizar seus próprios programas'],

            // 🔹 Pedidos musicais
            ['name' => 'can_list_song_requests', 'label' => 'Listar pedidos musicais'],
            ['name' => 'can_view_song_request', 'label' => 'Visualizar um pedido musical específico'],
            ['name' => 'can_mark_song_request_as_played', 'label' => 'Marcar pedido musical como tocado'],

            // 🔹 Calendário / Agenda
            ['name' => 'can_list_calendar_events', 'label' => 'Listar eventos da agenda'],
            ['name' => 'can_view_calendar_event', 'label' => 'Visualizar um evento da agenda'],
            ['name' => 'can_create_calendar_event', 'label' => 'Criar novo evento na agenda'],
            ['name' => 'can_update_calendar_event', 'label' => 'Atualizar um evento da agenda'],
            ['name' => 'can_delete_calendar_event', 'label' => 'Excluir um evento da agenda'],
            ['name' => 'can_view_own_calendar_event', 'label' => 'Visualizar seus próprios eventos'],
            ['name' => 'can_update_own_calendar_event', 'label' => 'Atualizar seus próprios eventos'],

            // 🔹 Gerenciamento de Cargos (Roles)
            ['name' => 'can_list_roles', 'label' => 'Listar cargos'],
            ['name' => 'can_view_role', 'label' => 'Visualizar um cargo específico'],
            ['name' => 'can_create_role', 'label' => 'Cadastrar um novo cargo'],
            ['name' => 'can_update_role', 'label' => 'Atualizar um cargo específico'],
            ['name' => 'can_delete_role', 'label' => 'Excluir um cargo específico'],

            // 🔹 Gerenciamento de Permissões
            ['name' => 'can_list_permissions', 'label' => 'Listar permissões'],
            ['name' => 'can_view_permission', 'label' => 'Visualizar uma permissão específica'],

        ];
        foreach($permissions as $item){
            Permission::create([
                'label' => $item['label'],
                'name' => $item['name']
            ]);
        }

    }
}
