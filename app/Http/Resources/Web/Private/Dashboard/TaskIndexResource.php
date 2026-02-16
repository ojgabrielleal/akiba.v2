<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Base\TaskBaseResource;
use App\Traits\ResolvesUserLogged;

class TaskIndexResource extends TaskBaseResource
{
    use ResolvesUserLogged;

    protected function user()
    {
        return $this->getUserLogged();
    }

    protected function isDue()
    {
        return $this->is_over || $this->is_due;
    }

    protected function ui()
    {
        return [
            'ui' => [
                'background' => $this->isDue() ? 
                    'bg-orange-amber' : 
                    'bg-blue-skywave',
                'title' => $this->isDue() ? 
                    'text-blue-midnight' :
                    'text-neutral-aurora',
                'content' => $this->isDue() ? 
                    'text-blue-midnight' : 
                    'text-neutral-aurora',
                'deadline' => [
                    'header' => [
                        'background' => $this->isDue() ? 
                            'bg-red-crimson' : 
                            'bg-blue-midnight',
                        'title' => $this->isDue() ? 
                            'text-blue-midnight' : 
                            'text-neutral-aurora',
                    ],
                    'body' => [
                        'background' => $this->isDue() ? 
                            'bg-blue-midnight' : 
                            'bg-neutral-aurora',
                        'text' => $this->isDue() ? 
                            'text-orange-amber' : 
                            'text-blue-midnight',
                    ]
                ],
                'confirmation' => [
                    'default' => $this->isDue() ?
                        'bg-red-crimson rounded-xl text-neutral-aurora uppercase absolute right-5 bottom-3 py-2 px-6' :
                        'bg-neutral-aurora absolute right-5 bottom-3 py-2 px-2 rounded-md flex justify-center items-center',
                ]
            ],
        ];
    }
    
    public function actions() 
    {
        $user = $this->user();
        $userCanComplete = $user['permissions']->contains('task.complete');

        return[
            'actions' => [
                'can_complete' => $userCanComplete,
            ]
        ];
    }

    public function toArray(Request $request): array
    {
        return array_merge(
            $this->base(['uuid', 'title', 'deadline_formated', 'content']),
            $this->ui(),
            $this->actions(),
            [
                'is_due' => $this->isDue()
            ]
        ); 
    }
}
