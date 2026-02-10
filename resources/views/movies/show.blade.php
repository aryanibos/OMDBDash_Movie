<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $movie['Title'] }} - MovieDB</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "primary-hover": "#104bc2",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                        "surface-dark": "#1a2233",
                        "surface-light": "#ffffff",
                    },
                    fontFamily: {
                        "display": ["Be Vietnam Pro", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        /* Custom scrollbar for webkit */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #101622; 
        }
        ::-webkit-scrollbar-thumb {
            background: #1a2233; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #252f45; 
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200 font-display min-h-screen flex flex-col antialiased">
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo area -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-lg">
                        M
                    </div>
                    <a href="{{ route('movies.index') }}" class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">MovieDB</a>
                </div>
                <!-- Nav Actions -->
                <div class="flex items-center gap-4">
                     <!-- User Profile -->
                    <div class="relative group">
                        <button class="flex items-center gap-3 focus:outline-none" onclick="document.getElementById('user-dropdown-detail').classList.toggle('hidden')">
                            <span class="text-sm font-medium hidden sm:block text-slate-600 dark:text-slate-300">{{ Auth::user()->name }}</span>
                            <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden border border-slate-300 dark:border-slate-600">
                                <img alt="User Avatar" class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=135bec&color=fff"/>
                            </div>
                        </button>
                        
                        <!-- Logout Dropdown -->
                        <div id="user-dropdown-detail" class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-surface-dark rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none hidden group-hover:block z-50">
                            <div class="px-4 py-2 border-b border-slate-200 dark:border-slate-700">
                                <p class="text-sm text-slate-900 dark:text-white font-bold">{{ Auth::user()->name }}</p>
                            </div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content Area -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumb / Back Navigation -->
            <div class="mb-8">
                <a class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors dark:text-slate-400 dark:hover:text-primary" href="{{ url()->previous() == url()->current() ? route('movies.index') : url()->previous() }}">
                    <span class="material-icons text-base">arrow_back</span>
                    Back to Search Results
                </a>
            </div>
            
            <!-- Content Card -->
            <div class="bg-white dark:bg-surface-dark rounded-xl shadow-xl dark:shadow-none dark:border dark:border-slate-800 overflow-hidden">
                <!-- Hero/Backdrop subtle gradient -->
                <div class="h-32 w-full bg-gradient-to-r from-slate-900 to-slate-800 relative opacity-50 hidden md:block">
                    <div class="absolute inset-0 bg-primary/10 mix-blend-overlay"></div>
                </div>
                <div class="flex flex-col md:flex-row p-6 md:p-8 gap-8 relative">
                    <!-- Left Column: Poster -->
                    <div class="flex-shrink-0 md:-mt-20 z-10 mx-auto md:mx-0 w-full md:w-auto flex justify-center md:block">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-primary to-purple-600 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                            <img alt="{{ $movie['Title'] }} Poster" class="relative w-64 h-96 object-cover rounded-xl shadow-2xl border-4 border-white dark:border-surface-dark" src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}"/>
                        </div>
                         <!-- Quick Stats below poster (Mobile only) -->
                        <div class="mt-6 flex justify-center gap-4 md:hidden">
                            <div class="flex flex-col items-center">
                                <span class="material-icons text-yellow-400">star</span>
                                <span class="font-bold text-lg dark:text-white">{{ $movie['imdbRating'] }}</span>
                                <span class="text-xs text-slate-500">IMDb</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Details -->
                    <div class="flex-grow space-y-6">
                        <!-- Header Section -->
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white leading-tight">
                                    {{ $movie['Title'] }}
                                    <span class="text-slate-400 font-normal text-2xl ml-2">({{ $movie['Year'] }})</span>
                                </h1>
                                <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                                    <span class="px-2 py-0.5 rounded border border-slate-300 dark:border-slate-600 text-xs font-semibold uppercase tracking-wider">{{ $movie['Rated'] }}</span>
                                    <span>{{ $movie['Runtime'] }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-400"></span>
                                    <span>{{ $movie['Released'] }}</span>
                                </div>
                            </div>
                            <!-- Desktop Rating -->
                            <div class="hidden md:flex items-center gap-4 bg-slate-50 dark:bg-background-dark px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700">
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-1 text-yellow-400">
                                        <span class="material-icons">star</span>
                                        <span class="text-xl font-bold text-slate-900 dark:text-white">{{ $movie['imdbRating'] }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500">{{ $movie['imdbVotes'] }} Votes</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Genre Tags -->
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(', ', $movie['Genre']) as $genre)
                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary border border-primary/20 text-sm font-medium">{{ $genre }}</span>
                            @endforeach
                        </div>
                        
                         <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-2">
                            @if($isFavorite)
                                <form action="{{ route('favorites.destroy', $movie['imdbID']) }}" method="POST" class="flex-1 sm:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-all shadow-lg shadow-red-500/30">
                                        <span class="material-icons">favorite</span>
                                        Remove from Favorites
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('favorites.store') }}" method="POST" class="flex-1 sm:flex-none">
                                    @csrf
                                    <input type="hidden" name="imdbID" value="{{ $movie['imdbID'] }}">
                                    <input type="hidden" name="Title" value="{{ $movie['Title'] }}">
                                    <input type="hidden" name="Poster" value="{{ $movie['Poster'] }}">
                                    <input type="hidden" name="Year" value="{{ $movie['Year'] }}">
                                    <input type="hidden" name="Type" value="{{ $movie['Type'] }}">
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-semibold transition-all shadow-lg shadow-primary/30">
                                        <span class="material-icons">favorite_border</span>
                                        Add to Favorites
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <hr class="border-slate-200 dark:border-slate-800"/>
                        
                        <!-- Plot -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Plot Summary</h3>
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-base">
                                {{ $movie['Plot'] }}
                            </p>
                        </div>
                        
                        <!-- Cast & Crew Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Director</span>
                                <span class="text-slate-900 dark:text-white font-medium">{{ $movie['Director'] }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Writer</span>
                                <span class="text-slate-900 dark:text-white font-medium">{{ $movie['Writer'] }}</span>
                            </div>
                            <div class="md:col-span-2">
                                <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Top Cast</span>
                                <div class="flex flex-wrap gap-4">
                                    @foreach(explode(', ', $movie['Actors']) as $actor)
                                        @if($loop->index < 4)
                                        <div class="flex items-center gap-3 bg-slate-50 dark:bg-background-dark p-2 rounded-lg pr-4 border border-slate-100 dark:border-slate-700">
                                            <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                                                <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($actor) }}&background=random" alt="{{ $actor }}"/>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $actor }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Awards Section -->
                        @if($movie['Awards'] != 'N/A')
                        <div class="mt-4 p-4 rounded-lg bg-yellow-500/10 border border-yellow-500/20">
                            <div class="flex gap-3">
                                <span class="material-icons text-yellow-500">emoji_events</span>
                                <div>
                                    <h4 class="text-sm font-bold text-yellow-600 dark:text-yellow-400 uppercase tracking-wide">Awards</h4>
                                    <p class="text-slate-700 dark:text-slate-300 text-sm mt-1">{{ $movie['Awards'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="mt-12 text-center text-slate-500 dark:text-slate-500 text-sm pb-8">
                <p>© {{ date('Y') }} MovieDB by Arya Isnaidi. All data provided by OMDB API.</p>
            </footer>
        </div>
    </main>
</body>
</html>
