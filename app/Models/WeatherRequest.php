<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeatherRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'requests';

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'parent');
    }
}
