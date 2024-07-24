<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'date', 'min_participants', 'max_participants', 'unique_url_id'
    ];

    protected $casts = [
        'date' => 'date',  // 'datetime' も可能です
    ];

    public function uniqueUrl()
    {
        return $this->belongsTo(UniqueUrl::class);
    }

    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}