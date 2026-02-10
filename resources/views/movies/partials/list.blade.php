@if(isset($movies) && count($movies) > 0)
    @foreach($movies as $movie)
        <div class="group relative bg-white dark:bg-surface-dark rounded-xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700/50 hover:border-primary/50 transition-all duration-300 hover:-translate-y-1 movie-item">
            <div class="aspect-[2/3] w-full relative overflow-hidden bg-slate-800">
                <img data-src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}" 
                     alt="{{ $movie['Title'] }}" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 lazy-load"
                     src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                     data-alt="{{ $movie['Title'] }}">
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 card-gradient opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                    <a href="{{ route('movies.show', $movie['imdbID']) }}" class="self-end mb-auto bg-white/20 backdrop-blur-sm p-2 rounded-full hover:bg-white/40 transition-colors">
                        <span class="material-icons-round text-white">info</span>
                    </a>
                </div>
            </div>
            <div class="p-4">
                <div class="flex justify-between items-start gap-2">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 dark:text-white truncate" title="{{ $movie['Title'] }}">{{ $movie['Title'] }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs font-medium px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">{{ $movie['Year'] }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ $movie['Type'] }}</span>
                        </div>
                    </div>
                    
                    @if(in_array($movie['imdbID'], $userFavorites))
                        <form action="{{ route('favorites.destroy', $movie['imdbID']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-primary hover:text-red-500 transition-colors transform active:scale-90" title="Remove from favorites">
                                <span class="material-icons-round">favorite</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favorites.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="imdbID" value="{{ $movie['imdbID'] }}">
                            <input type="hidden" name="Title" value="{{ $movie['Title'] }}">
                            <input type="hidden" name="Poster" value="{{ $movie['Poster'] }}">
                            <input type="hidden" name="Year" value="{{ $movie['Year'] }}">
                            <input type="hidden" name="Type" value="{{ $movie['Type'] }}">
                            <button type="submit" class="text-slate-400 dark:text-slate-600 hover:text-primary transition-colors transform active:scale-90" title="Add to favorites">
                                <span class="material-icons-round">favorite_border</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@elseif(isset($error) && !request()->ajax())
    <div class="col-span-full text-center py-10">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-500 mb-4">
            <span class="material-icons-round text-3xl">error_outline</span>
        </div>
        <h3 class="text-lg font-medium text-slate-900 dark:text-white">{{ $error }}</h3>
        <p class="text-slate-500 dark:text-slate-400">Please try adjusting your search parameters.</p>
    </div>
@endif
