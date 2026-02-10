<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>My Favorites List - Movie App</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Be Vietnam Pro", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        /* Custom scrollbar for better aesthetic in dark mode */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #101622; 
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155; 
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200 font-display antialiased min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.location.href='{{ route('movies.index') }}'">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-white shadow-lg shadow-primary/20">
                        <span class="material-icons text-xl">movie</span>
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-900 dark:text-white">Cine<span class="text-primary">Stash</span></span>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a class="text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors" href="{{ route('movies.index') }}">Browse</a>
                        <a class="bg-primary/10 text-primary px-3 py-2 rounded-md text-sm font-medium" href="{{ route('favorites.index') }}">Favorites</a>
                    </div>
                </div>
                <!-- Search & Profile -->
                <div class="flex items-center gap-4">
                    <form action="{{ route('movies.index') }}" method="GET" class="relative hidden sm:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-icons text-slate-400 text-sm">search</span>
                        </div>
                        <input type="text" name="s" class="block w-full pl-10 pr-3 py-1.5 border border-slate-200 dark:border-slate-700 rounded-lg leading-5 bg-white dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm transition-all" placeholder="Search movies..." />
                    </form>
                    
                    <div class="relative group">
                        <button class="flex items-center gap-3 focus:outline-none" onclick="document.getElementById('user-dropdown-fav').classList.toggle('hidden')">
                             <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-slate-700 to-slate-600 border border-slate-600 overflow-hidden cursor-pointer relative">
                                <img alt="User Avatar" class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=135bec&color=fff"/>
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-all"></div>
                            </div>
                        </button>

                        <!-- Logout Dropdown -->
                        <div id="user-dropdown-fav" class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none hidden group-hover:block z-50">
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

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">My Favorites</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Manage your personal collection of top picks.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                <span class="material-icons text-primary text-base">favorite</span>
                <span>{{ $favorites->count() }} Movies Saved</span>
            </div>
        </div>

        @if($favorites->count() > 0)
            <!-- Grid Layout -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($favorites as $movie)
                <!-- Movie Card -->
                <div class="group relative bg-white dark:bg-slate-800/50 rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary/10 border border-slate-200 dark:border-slate-700/50 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative aspect-[2/3] overflow-hidden">
                        <a href="{{ route('movies.show', $movie->imdbID) }}">
                            <img alt="{{ $movie->Title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $movie->Poster && $movie->Poster != 'N/A' ? $movie->Poster : 'https://via.placeholder.com/300x450?text=No+Poster' }}"/>
                        </a>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-60 group-hover:opacity-80 transition-opacity pointer-events-none"></div>
                        
                        <!-- Floating Remove Button -->
                        <form action="{{ route('favorites.destroy', $movie->imdbID) }}" method="POST" class="absolute top-2 right-2 z-10">
                            @csrf
                            @method('DELETE')
                            <button type="submit" aria-label="Remove from favorites" class="p-2 bg-black/40 backdrop-blur-sm hover:bg-red-500/90 text-white rounded-full transition-colors duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100 cursor-pointer">
                                <span class="material-icons text-sm">delete</span>
                            </button>
                        </form>
                        
                        <!-- Type Badge -->
                        <span class="absolute top-2 left-2 px-2 py-0.5 text-xs font-semibold bg-primary/90 text-white rounded backdrop-blur-sm capitalize">{{ $movie->Type }}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 dark:text-white truncate" title="{{ $movie->Title }}">
                            <a href="{{ route('movies.show', $movie->imdbID) }}">{{ $movie->Title }}</a>
                        </h3>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $movie->Year }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State Component -->
            <div class="flex flex-col items-center justify-center py-24 text-center animate-fade-in">
                <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-6 ring-1 ring-slate-200 dark:ring-slate-700">
                    <span class="material-icons text-5xl text-slate-300 dark:text-slate-500">favorite_border</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">No favorites yet</h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-8">Start adding movies to your list to keep track of what you want to watch next.</p>
                <a class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20" href="{{ route('movies.index') }}">
                    Browse Movies
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 dark:border-slate-800 mt-auto bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500 dark:text-slate-400">© {{ date('Y') }} CineStash by Arya Isnaidi. All rights reserved.</span>
            </div>
            <div class="flex space-x-6 text-sm text-slate-500 dark:text-slate-400">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="hover:text-primary transition-colors" href="#">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
