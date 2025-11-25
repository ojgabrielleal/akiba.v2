<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Exceptions\AlreadyExistsException;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\Event;

class EventsController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function listEvents()
    {
        try {
            $authenticated = request()->user();
            
            $query = Event::orderBy('created_at', 'desc');
            $query->with('user');
            $query->when(!$authenticated->permissions_keys->contains('administrator'), function ($q) use ($authenticated) { 
                $q->where('user_id', $authenticated->id); 
            });
            $query->where('is_active', true);
            $events = $query->paginate(10);

            $events->getCollection()->transform(function ($event) use ($authenticated) {
                $data = $event->toArray();
                $data['actions'] = [
                    'editable' => true,
                    'deactivate' => $authenticated->permissions_keys->contains('administrator')
                ];
                $data['styles'] = [
                    'bg' => 'var(--color-blue-skywave)',
                ];
                return $data;
            });

            return $events;
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function getEvent($slug)
    {
        try {
            if($slug){
                return Event::where('slug', $slug)->firstOrFail();
            }
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createEvent(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'image' => 'required',
                'cover' => 'required',
                'content' => 'required',
                'dates' => 'required',
                'address' => 'required',
            ], [
                "title.required" => "Nome do evento",
                "image.required" => "Imagem em destaque",
                "cover.required" => "Capa do evento",
                "content.required" => "Escreva sobre o evento",
                "dates.required" => "Datas",
                "address.required" => "Local",
            ]);

            $exists = Event::where('title', $request->input('title'))->exists();
            if($exists) throw new AlreadyExistsException();

            $authenticated = request()->user();

            Event::create([
                'user_id' => $authenticated->id,
                'slug' => Str::slug($request->input('title')),
                'image' => $this->uploadImage('events', $request->file('image')),
                'cover' => $this->uploadImage('events', $request->file('cover')),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'dates' => $request->input('dates'),
                'address' => $request->input('address')
            ]);
            
            return $this->provideSuccess('save');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateEvent(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'dates' => 'required',
                'address' => 'required',
            ], [
                "title.required" => "Nome do evento",
                "content.required" => "Escreva sobre o evento",
                "dates.required" => "Datas",
                "address.required" => "Local",
            ]);

            $event = Event::where('id', $id)->firstOrFail();
            $event->update([
                'slug' => $request->input('title') !== $event->title ? Str::slug($request->input('title')) : $event->slug,
                'image' => $request->hasFile('image') ? $this->uploadImage('events', $request->file('image'), 'public', $event->image) : $event->image,
                'cover' => $request->hasFile('cover') ? $this->uploadImage('events', $request->file('cover'), 'public', $event->cover) : $event->cover,
                'title' => $request->input('title', $event->title),
                'content' => $request->input('content', $event->content),
                'dates' => $request->input('dates', $event->dates),
                'address' => $request->input('address', $event->address),
            ]);

            return $this->provideSuccess('update');
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Events', [
            "publications" => $this->listEvents(),
            "publication" => $this->getEvent($slug)
        ]);
    }
}
