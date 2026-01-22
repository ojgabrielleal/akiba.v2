<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ListenerMonth extends Model
{
    use HasFactory;

    protected $table = 'listener_month';

    protected $fillable = [
        'name',
        'avatar',
        'address',
        'favorite_program',
        'requests_count',
    ];

    /**
     * Static query methods for this model.
     *
     * These methods encapsulate complete query logic and business
     * rules that return finalized results, such as reports,
     * aggregations, or single-record lookups. Unlike query scopes,
     * they execute the query internally (e.g., first(), get())
     * and are intended to be called directly on the model.
     *
     */
    public static function mostActiveListenerOfCurrentMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        return self::where('listeners_requests.status', 'granted')
            ->join('onair', 'listeners_requests.onair_id', '=', 'onair.id')
            ->join('programs', 'onair.program_id', '=', 'programs.id')
            ->whereBetween('listeners_requests.created_at', [$startOfMonth, $endOfMonth])
            ->select(
                'listener',
                'listeners_requests.address',
                'programs.name as favorite_program',
                DB::raw('COUNT(*) as request_count')
            )
            ->groupBy('listener', 'listeners_requests.address', 'programs.name')
            ->orderByDesc('request_count')
            ->first();
    }
}
