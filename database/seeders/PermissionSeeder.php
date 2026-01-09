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
            | ⚙️ Accessos as páginas Gerais
            |--------------------------------------------------------------------------
            */
            ['name' => 'access.page.dashboard', 'label' => 'Acessar página dashboard do painel'],
            ['name' => 'access.page.warnings', 'label' => 'Acessar página avisos do sistema'],
            ['name' => 'access.page.posts', 'label' => 'Acessar página matérias do sistema'],
            ['name' => 'access.page.broadcast', 'label' => 'Acessar página locução do sistema'],
            ['name' => 'access.page.radio', 'label' => 'Acessar página rádio do sistema'],
            ['name' => 'access.page.podcasts', 'label' => 'Acessar página podcasts do sistema'],
            ['name' => 'access.page.marketing', 'label' => 'Acessar página marketing do sistema'],
            ['name' => 'access.page.media', 'label' => 'Acessar página mídias do sistema'],
            ['name' => 'access.page.administration', 'label' => 'Acessar página administração do sistema'],
            ['name' => 'access.page.logs', 'label' => 'Acessar página logs do sistema'],
            
            /*
            |--------------------------------------------------------------------------
            | ⚙️ Atividades e avisos
            |--------------------------------------------------------------------------
            */
            ['name' => 'activity.list', 'label' => 'Listar atividades e avisos'],
            ['name' => 'activity.view', 'label' => 'Visualizar atividade e aviso'],
            ['name' => 'activity.create', 'label' => 'Criar atividades e avisos'],
            ['name' => 'activity.update', 'label' => 'Atualizar atividades e avisos'],
            ['name' => 'activity.deactivate', 'label' => 'Desativar atividades e avisos'],
            ['name' => 'activity.participate', 'label' => 'Confirmar participação em uma atividade'],

            /*
            |--------------------------------------------------------------------------
            | ⚙️ Tarefas
            |--------------------------------------------------------------------------
            */
            ['name' => 'task.list', 'label' => 'Listar tarefas'],
            ['name' => 'task.view', 'label' => 'Visualizar tarefa'],
            ['name' => 'task.create', 'label' => 'Criar tarefa'],
            ['name' => 'task.update', 'label' => 'Atualizar tarefa'],
            ['name' => 'task.deactivate', 'label' => 'Desativar tarefa'],
            ['name' => 'task.complete', 'label' => 'Confirmar tarefa como concluída'],

            /*
            |--------------------------------------------------------------------------
            | 📝 Posts
            |--------------------------------------------------------------------------
            */
            ['name' => 'post.list', 'label' => 'Listar posts'],
            ['name' => 'post.view', 'label' => 'Visualizar post'],
            ['name' => 'post.create', 'label' => 'Criar post'],
            ['name' => 'post.update', 'label' => 'Atualizar post'],
            ['name' => 'post.deactivate', 'label' => 'Desativar post'],
            ['name' => 'post.update.own', 'label' => 'Atualizar próprio post'],

            /*
            |--------------------------------------------------------------------------
            | 📅 Calendário
            |--------------------------------------------------------------------------
            */
            ['name' => 'calendar.list', 'label' => 'Listar eventos no calendário'],
            ['name' => 'calendar.view', 'label' => 'Visualizar evento no calendário'],
            ['name' => 'calendar.create', 'label' => 'Criar evento no calendário'],
            ['name' => 'calendar.update', 'label' => 'Atualizar evento no calendário'],
            ['name' => 'calendar.deactivate', 'label' => 'Excluir evento no calendário'],

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
            ['name' => 'show.list', 'label' => 'Listar programas'],
            ['name' => 'show.view', 'label' => 'Visualizar programa'],
            ['name' => 'show.create', 'label' => 'Criar programa'],
            ['name' => 'show.update', 'label' => 'Atualizar programa'],
            ['name' => 'show.delete', 'label' => 'Excluir programa'],
            ['name' => 'show.view.own', 'label' => 'Visualizar próprios programas'],

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
