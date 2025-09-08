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


    public function render()
    {
        return Inertia::render('admin/Events', [
            "publications" => $this->getEvents(),
        ]);
    }
}
