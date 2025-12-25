<?php

namespace App\Services\Domain;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\Process\ImageService;
use App\Models\ListenerMonth;

class ListenerMonthService
{
    public function get()
    {
        return ListenerMonth::where('id', 1)->first();
    }

    public function create($data = [])
    {
        $image = new ImageService();

        $exists = ListenerMonth::exists();
        $found = $this->found();

        if ($exists) {
            $listenerMonthQuery = ListenerMonth::where('id', 1)->firstOrFail();

            $listenerMonthUpdate = $listenerMonthQuery->update([
                'image' => $image->upload('listener-month', $data['image'], 'public', $listenerMonthQuery->image ?? null),
                'listener' => $found->listener,
                'address' => $found->address,
                'favorite_show' => $found->favorite_show,
                'requests_total' => $found->total,
            ]);

            return $listenerMonthUpdate;
        } else {
            DB::statement('ALTER TABLE listener_month AUTO_INCREMENT = 1');

            $listenerMonthCreate = ListenerMonth::create([
                'image' => $image->upload('listener-month', $data['image'], 'public'),
                'listener' => $found->listener,
                'address' => $found->address,
                'favorite_show' => $found->favorite_show,
                'requests_total' => $found->total,
            ]);

            return $listenerMonthCreate;
        }
    }

    public function found()
    {
        $startOfMonthCarbon = Carbon::now()->startOfMonth();
        $endOfMonthCarbon = Carbon::now()->endOfMonth();

        $queryDb = DB::table('listeners_requests');
        $queryDb->where('status', 'granted');
        $queryDb->join('onair', 'listeners_requests.onair_id', '=', 'onair.id');
        $queryDb->join('shows', 'onair.program_id', '=', 'shows.id');
        $queryDb->whereBetween('listeners_requests.created_at', [$startOfMonthCarbon, $endOfMonthCarbon]);
        $queryDb->select('listener', 'listeners_requests.address', 'shows.name as favorite_show', DB::raw('COUNT(*) as total'));
        $queryDb->groupBy('listener', 'listeners_requests.address', 'shows.name');
        $queryDb->orderByDesc('total');

        $listenerFound = $queryDb->first();

        return $listenerFound;
    }
}
