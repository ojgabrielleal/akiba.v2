<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Event;

use App\Http\Resources\EventIndexResource;
use App\Http\Resources\EventShowResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class EventController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Event';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function indexEvents()
    {
        return EventIndexResource::collection(
            Event::active()
                ->with('author')
                ->paginate(10)
        );
    }

    public function showEvent(Event $event)
    {
        return Inertia::render($this->render, [
            'event' => new EventShowResource($event->load('author')),
            'events' => $this->indexEvents()
        ]);
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'title' => 'required:events,title',
            'image' => 'required',
            'cover' => 'required',
            'content' => 'required',
            'dates' => 'required',
            'address' => 'required',
        ]);

        Event::create([
            'user_id' => request()->user()->id,
            'image' => $this->image->store('events', $request->file('image')),
            'cover' => $this->image->store('events', $request->file('cover')),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'dates' => $request->input('dates'),
            'address' => $request->input('address'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateEvent(Request $request, Event $event)
    {
        $event->fill([
            'image' => $this->image->store('events', $request->file('image'), 'public', $event->image),
            'cover' => $this->image->store('events', $request->file('cover'), 'public', $event->cover),
            'title' => $request->input('title', $event->title),
            'content' => $request->input('content', $event->content),
            'dates' => $request->input('dates', $event->dates),
            'address' => $request->input('address', $event->address),
        ]);

        if ($event->isDirty()) {
            $event->save();
        }

        return $this->flashMessage('update');
    }


    public function render()
    {
        return Inertia::render($this->render, [
            "events" => $this->indexEvents(),
        ]);
    }
}
