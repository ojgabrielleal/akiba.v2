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
            | Accessos as páginas Gerais
            |--------------------------------------------------------------------------
            */
            ['name' => 'dashboard.view', 'label' => 'Acessar página dashboard do painel'],
            ['name' => 'warning.view', 'label' => 'Acessar página avisos do sistema'],
            ['name' => 'post.view', 'label' => 'Acessar página matérias do sistema'],
            ['name' => 'broadcast.view', 'label' => 'Acessar página locução do sistema'],
            ['name' => 'radio.view', 'label' => 'Acessar página rádio do sistema'],
            ['name' => 'podcast.view', 'label' => 'Acessar página podcasts do sistema'],
            ['name' => 'marketing.view', 'label' => 'Acessar página marketing do sistema'],
            ['name' => 'media.view', 'label' => 'Acessar página mídias do sistema'],
            ['name' => 'administration.view', 'label' => 'Acessar página administração do sistema'],
            ['name' => 'log.view', 'label' => 'Acessar página logs do sistema'],
            
            /*
            |--------------------------------------------------------------------------
            | Atividades e avisos
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
            | Tarefas
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
            | Calendário
            |--------------------------------------------------------------------------
            */
            ['name' => 'calendar.list', 'label' => 'Listar eventos no calendário'],
            ['name' => 'calendar.view', 'label' => 'Visualizar evento no calendário'],
            ['name' => 'calendar.create', 'label' => 'Criar evento no calendário'],
            ['name' => 'calendar.update', 'label' => 'Atualizar evento no calendário'],
            ['name' => 'calendar.deactivate', 'label' => 'Excluir evento no calendário'],

            /*
            |--------------------------------------------------------------------------
            | Posts
            |--------------------------------------------------------------------------
            */
            ['name' => 'post.list', 'label' => 'Listar posts'],
            ['name' => 'post.list.own', 'label' => 'Listar próprios posts'],
            ['name' => 'post.view', 'label' => 'Visualizar post'],
            ['name' => 'post.create', 'label' => 'Criar post'],
            ['name' => 'post.update', 'label' => 'Atualizar post'],
            ['name' => 'post.update.own', 'label' => 'Atualiza próprio post'],
            ['name' => 'post.deactivate', 'label' => 'Desativar post'],

        ];
        
        foreach($permissions as $item){
            Permission::create([
                'label' => $item['label'],
                'name' => $item['name']
            ]);
        }

    }
}
