<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Film extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function watchlist()
    {
        return $this->belongsTo(Watchlist::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
