<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use App\Traits\Response\ProvideException;
use App\Traits\Response\ProvideSuccess;
use App\Traits\Upload\HandlesImageUpload;

use App\Models\Event;

class EventsController extends Controller
{
    use HandlesImageUpload, ProvideSuccess, ProvideException;

    public function getEvents()
    {
        try {
            $user = request()->user();
            $query = Event::orderBy('created_at', 'desc');
            $query->with('user');
            $query->when(!$user->permissions_keys->contains('administrator'), function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            $events = $query->paginate(10);

            $events->getCollection()->transform(function ($event) {
                $data = $event->toArray();
                $data['editable'] = true;
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
            if ($slug) {
                $query = Event::where('slug', $slug);
                return $query->first();
            }
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function updateEvent(Request $request, $slug)
    {
        try {
            $event = Event::where('slug', $slug)->first();

            $slug = Str::slug($request->input('title'));
            $image = $request->hasFile('image') ? $this->uploadImage('posts', $request->file('image')) : $event->image;
            $cover = $request->hasFile('cover') ? $this->uploadImage('posts', $request->file('cover')) : $event->cover;

            $event->update([
                'slug' => $slug,
                'image' => $image,
                'cover' => $cover,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'dates' => $request->input('dates'),
                'address' => $request->input('address')
            ]);

            $this->ProvideSuccess('update');
            return redirect()->route('render.painel.eventos', ['slug' => $slug]);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function createEvent(Request $request)
    {
        try {
            $slug = Str::slug($request->input('title'));

            Event::create([
                'slug' => $slug,
                'image' => $request->file('image'),
                'cover' => $request->file('cover'),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'dates' => $request->input('dates'),
                'address' => $request->input('address')
            ]);

            $this->ProvideSuccess('created');
            return redirect()->route('render.painel.eventos', ['slug' => $slug]);
        } catch (\Throwable $e) {
            return $this->provideException($e);
        }
    }

    public function render($slug = null)
    {
        return Inertia::render('admin/Events', [
            "publications" => $this->getEvents(),
            "publication" => $this->getEvent($slug)
        ]);
    }
}
