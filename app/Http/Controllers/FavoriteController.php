<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->orderBy('created_at', 'desc')->get();
        // Determine if there's any error message from session? usually handled by blade.
        
        // Transform favorites to match the partial's expected structure if needed.
        // The partial expects array keys: Title, Year, Poster, imdbID.
        // The model has attributes: Title, Year, Poster, imdbID.
        // It should match fine.
        
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'imdbID' => 'required',
            'Title' => 'required',
            'Year' => 'required',
            'Type' => 'required',
        ]);

        $user = Auth::user();
        
        // Check if already exists
        if ($user->favorites()->where('imdbID', $request->imdbID)->exists()) {
            return redirect()->back()->with('error', 'Movie is already in your favorites!');
        }

        $user->favorites()->create($request->all());

        return redirect()->back()->with('success', 'Movie added to favorites!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $imdbID
     * @return \Illuminate\Http\Response
     */
    public function destroy($imdbID)
    {
        $favorite = Auth::user()->favorites()->where('imdbID', $imdbID)->firstOrFail();
        $favorite->delete();

        return redirect()->route('favorites.index')->with('success', 'Movie removed from favorites!');
    }
}
