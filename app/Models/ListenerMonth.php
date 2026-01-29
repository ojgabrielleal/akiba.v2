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

        return DB::select('
            SELECT songs_requests.name AS listener_name,
                songs_requests.address AS address,
                COUNT(*) AS total_requests,
                programs.name AS favorite_program
            FROM songs_requests
            JOIN onair ON songs_requests.onair_id = onair.id
            JOIN programs ON onair.program_id = programs.id
            WHERE songs_requests.created_at BETWEEN ? AND ?
            GROUP BY songs_requests.name, programs.name
            ORDER BY total_requests DESC
            LIMIT 1
        ', [$startOfMonth, $endOfMonth]);
    }
}
