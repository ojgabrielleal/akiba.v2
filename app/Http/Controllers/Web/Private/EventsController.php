<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;

use App\Services\Domain\EventService;

class EventsController extends Controller
{
    use FlashMessageTrait;
   
    public function createEvent(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'cover' => 'required',
            'content' => 'required',
            'dates' => 'required',
            'address' => 'required',
        ]);

        $authenticated = request()->user();

        $event = new EventService();
        $create = $event->create($authenticated, $request->all());

        if($create){
            return $this->flashMessage('save');
        }
    }

    public function updateEvent(Request $request, $eventId)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'dates' => 'required',
            'address' => 'required',
        ]);

        $event = new EventService();
        $update = $event->update($eventId, $request->all());

        if($update){
            return $this->flashMessage('update');
        }
    }

    public function render($eventSlug = null)
    {
        $event = new EventService();

        return Inertia::render('admin/Events', [
            "publications" => $event->list(),
            "publication" => $event->get($eventSlug)
        ]);
    }
}
