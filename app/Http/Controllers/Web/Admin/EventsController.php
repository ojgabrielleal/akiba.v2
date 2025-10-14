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

    public function updateEvent(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'dates' => 'required',
                'address' => 'required',
            ], [
                "title.required" => "<b><i>Nome do evento</b></i> é obrigatório",
                "content.required" => "<b><i>Escreva sobre o evento</b></i> é obrigatório",
                "dates.required" => "<b><i>Datas</b></i> é obrigatório",
                "address.required" => "<b><i>Local</b></i> é obrigatório",
            ]);

            $event = Event::where('id', $id)->first();

            $slug = $request->input('title') !== $event->title ? Str::slug($request->input('title')) : $event->slug;
            $image = $request->hasFile('image') ? $this->uploadImage('events', $request->file('image'), 'public', $event->image) : $event->image;
            $cover = $request->hasFile('cover') ? $this->uploadImage('events', $request->file('cover'), 'public', $event->cover) : $event->cover;
            $title = $request->input('title') !== $event->title ? $request->input('title') : $event->title;
            $content = $request->input('content') !== $event->content ? $request->input('content') : $event->content;
            $dates = $request->input('dates') !== $event->dates ? $request->input('dates') : $event->dates;
            $address = $request->input('address') !== $event->address ? $request->input('address') : $event->address;

            $event->update([
                'slug' => $slug,
                'image' => $image,
                'cover' => $cover,
                'title' => $title,
                'content' => $content,
                'dates' => $dates,
                'address' => $address
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
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|max:2048',
                'cover' => 'required|image|max:2048',
                'content' => 'required',
                'dates' => 'required',
                'address' => 'required',
            ], [
                "title.required" => "<b><i>Nome do evento</b></i> é obrigatório",
                "image.required" => "<b><i>Imagem em destaque</b></i> é obrigatório",
                "cover.required" => "<b><i>Capa do evento</b></i> é obrigatório",
                "content.required" => "<b><i>Escreva sobre o evento</b></i> é obrigatório",
                "dates.required" => "<b><i>Datas</b></i> é obrigatório",
                "address.required" => "<b><i>Local</b></i> é obrigatório",
            ]);

            Log::info($request);
            $user = request()->user();
            $slug = Str::slug($request->input('title'));

            Event::create([
                'user_id' => $user->id,
                'slug' => $slug,
                'image' => $this->uploadImage('events', $request->file('image')),
                'cover' => $this->uploadImage('events', $request->file('cover')),
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'dates' => $request->input('dates'),
                'address' => $request->input('address')
            ]);

            $this->ProvideSuccess('save');
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
