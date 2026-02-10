<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OmdbService;

class MovieController extends Controller
{
    protected $omdbService;

    public function __construct(OmdbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    /**
     * Display a listing of the movies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('s', 'Batman');
        $page = $request->input('page', 1);
        $type = $request->input('type');
        $year = $request->input('y');
        
        $movies = [];
        $error = null;

        if ($keyword) {
            $result = $this->omdbService->search($keyword, $page, $type, $year);
            if (isset($result['Search'])) {
                $movies = $result['Search'];
            } elseif (isset($result['Error'])) {
                $error = $result['Error'];
            }
        }
        
        $userFavorites = auth()->check() ? auth()->user()->favorites()->pluck('imdbID')->toArray() : [];

        if ($request->ajax()) {
            return view('movies.partials.list', compact('movies', 'userFavorites'));
        }

        return view('movies.index', compact('movies', 'keyword', 'error', 'type', 'year', 'userFavorites'));
    }

    /**
     * Display the specified movie.
     *
     * @param  string  $imdbID
     * @return \Illuminate\Http\Response
     */
    public function show($imdbID)
    {
        $movie = $this->omdbService->getDetails($imdbID);
        
        if(isset($movie['Error'])) {
            return redirect()->route('movies.index')->with('error', $movie['Error']);
        }

        $isFavorite = false;
        if(auth()->check()) {
            $isFavorite = auth()->user()->favorites()->where('imdbID', $imdbID)->exists();
        }

        return view('movies.show', compact('movie', 'isFavorite'));
    }
}
