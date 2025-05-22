<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnairControlsModel extends Model
{
    protected $table = 'onair_controls';

    protected $fillable = [
        'onair_id',
        'listener_request_status',
        'listener_request_count',
    ];

    protected $casts = [
        'listener_request_status' => 'boolean',
    ];

    /**
     * Relationship from model 'Onair'
     */
    public function onair()
    {
        return $this->belongsTo(OnairModel::class);
    }
}
