<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UniqueUrl extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'user_id'];

    public static function generateUniqueUrl()
    {
        $url = Str::random(10);
        while (self::where('url', $url)->exists()) {
            $url = Str::random(10);
        }
        return $url;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}