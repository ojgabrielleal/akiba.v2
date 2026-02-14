<?php

namespace App\Http\Resources\Web\Private\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Traits\ResolvesUserLogged;

class TaskIndexResource extends JsonResource
{
    use ResolvesUserLogged;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->getUserLogged();

        // Conditional to know is over or due;
        $isDueOrOver = $this->is_over || $this->is_due;

        //Verify if contains task.complete permission
        $canComplete = $user['permissions']->contains('task.complete');

        return [
            'uuid' => $this->uuid,
            'is_due' => $isDueOrOver,
            'title' => $this->title,
            'content' => $this->content,
            'deadline' => $this->deadline?->format('d/m'),
            'ui' => [
                'background' => $isDueOrOver ? 'bg-orange-amber' : 'bg-blue-skywave',
                'title' => $isDueOrOver ? 'text-blue-midnight' : 'text-neutral-aurora',
                'content' => $isDueOrOver ? 'text-blue-midnight' : 'text-neutral-aurora',
                'deadline' => [
                    'header' => [
                        'background' => $isDueOrOver ? 'bg-red-crimson' : 'bg-blue-midnight',
                        'title' => $isDueOrOver ? 'text-blue-midnight' : 'text-neutral-aurora',
                    ],
                    'body' => [
                        'background' => $isDueOrOver ? 'bg-blue-midnight' : 'bg-neutral-aurora',
                        'text' => $isDueOrOver ? 'text-orange-amber' : 'text-blue-midnight',
                    ]
                ],
                'confirmation' => [
                    'default' => $isDueOrOver ?
                        'bg-red-crimson rounded-xl text-neutral-aurora uppercase absolute right-5 bottom-3 py-2 px-6' :
                        'bg-neutral-aurora absolute right-5 bottom-3 py-2 px-2 rounded-md flex justify-center items-center',
                ]
            ],
            'actions' => [
                'can_complete' => $canComplete,
            ]
        ];
    }
}
