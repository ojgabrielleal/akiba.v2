<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onair extends Model
{
    protected $table = 'onair';

    protected $fillable = [
        'is_played',
        'show_id',
        'show_type',
        'category',
        'phrase',
        'image',
        'listener_request_status',
        'listener_request_total'
    ];

    protected $casts = [
        'is_played' => 'boolean'
    ];

    protected $hidden = [
        'show_id'
    ];

    public function show()
    {
        return $this->morphTo();
    }
}
