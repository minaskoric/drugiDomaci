<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Film;

class FilmTestController extends Controller
{
    public function index() 
    {
        $films = Film::all();
        return $films;
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'naziv_filma'=> 'required|string|max:255',
            'imdb_ocena'=> 'required|string|max:255',
            'o_filmu'=> 'required',
            'watchlist_id'=> 'required'
        ]);

        if ($validator->fails())
        return response()->json($validator->errors());

    $film = Film::create([
        'naziv_filma' => $request->naziv_filma,
        'imdb_ocena' => $request->imdb_ocena,
        'o_filmu' => $request->o_filmu,
        'watchlist_id' => $request->watchlist_id,
        'user_id' => Auth::user()->id,
    ]);

    return response()->json(['Film is created successfully.']);
        
    }


    public function show($id) 
    {
        $films = Film::find($id);
        return $films;
    }
    public function update(Request $request, Film $film) {
        $validator = Validator::make($request->all(), [
            'naziv_filma'=> 'required|string|max:255',
            'imdb_ocena'=> 'required|string|max:255',
            'o_filmu'=> 'required',
            'watchlist_id'=> 'required',
        ]);

        if ($validator->fails())
        return response()->json($validator->errors());

    $film = Film::create([
       $film-> naziv_filma = $request->naziv_filma,
       $film->imdb_ocena = $request->imdb_ocena,
       $film-> o_filmu = $request->o_filmu,
       $film-> watchlist_id = $request->watchlist_id
    ]);
    $film->save();

    return response()->json(['Film is updated successfully.', new FilmResource($film)]);
        
    }
}
