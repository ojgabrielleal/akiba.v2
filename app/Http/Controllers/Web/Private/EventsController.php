<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\FlashMessageTrait;
use App\Services\Process\ImageService;

use App\Models\Event;

class EventsController extends Controller
{
    use FlashMessageTrait;

    private ImageService $image;
    private $render = 'private/Events';

    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    public function indexEvents()
    {
        return Event::active()
                ->with('author')
                ->paginate(10);
    }

    public function showEvent(Event $event)
    {
        return Inertia::render($this->render, [
            'event' => $event->load('author'),
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

        if($event->isDirty()){
            $event->save();
        }

        return $this->flashMessage('update');
    }


    public function render()
    {
        return Inertia::render($this->render, [
            "publications" => $this->indexEvents(),
        ]);
    }
}
