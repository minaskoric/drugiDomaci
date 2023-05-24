<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;

class WatchlistTestController extends Controller
{
    public function index() 
    {
        $watchlists = Watchlist::all();
        return $watchlists;
    }

    public function show($id) 
    {
        $watchlists = Watchlist::find($id);
        return $watchlists;
    }
    
}
