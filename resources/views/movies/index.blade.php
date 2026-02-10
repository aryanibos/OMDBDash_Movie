<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Movie List Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "primary-dark": "#0e44b3",
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
            background: #2d3748; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #4a5568; 
        }
        
        .card-gradient {
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 60%, rgba(0,0,0,0) 100%);
        }
        
        /* Shimmer effect for skeletons */
        .shimmer {
            background: linear-gradient(90deg, #1a2233 25%, #252e42 50%, #1a2233 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    <!-- jQuery for Infinite Scroll -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-800 dark:text-slate-100 min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white dark:bg-background-dark/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-2">
                    <div class="bg-primary rounded-lg p-1.5 shadow-lg shadow-primary/30">
                        <span class="material-icons-round text-white text-xl">movie_filter</span>
                    </div>
                    <a href="{{ route('movies.index') }}" class="font-bold text-xl tracking-tight dark:text-white hover:opacity-80 transition-opacity">
                        OMDB<span class="text-primary">Dash</span>
                    </a>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    <a class="px-4 py-2 rounded-lg text-sm font-medium text-primary bg-primary/10 transition-colors" href="{{ route('movies.index') }}">
                        {{ __('Movies') }}
                    </a>
                    <a class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('favorites.index') }}">
                        {{ __('Favorites') }}
                    </a>
                </div>
                <!-- Right Actions: Language & User -->
                <div class="flex items-center gap-4">
                    <!-- Language Switcher -->
                    <div class="relative group">
                         <div class="relative inline-block text-left">
                            <button type="button" class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary transition-colors focus:outline-none" id="lang-menu-button" aria-expanded="true" aria-haspopup="true">
                                <span class="material-icons-round text-lg">language</span>
                                <span>{{ strtoupper(app()->getLocale()) }}</span>
                                <span class="material-icons-round text-sm">expand_more</span>
                            </button>
                             <!-- Dropdown menu -->
                            <div class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white dark:bg-surface-dark ring-1 ring-black ring-opacity-5 focus:outline-none hidden group-hover:block" role="menu" aria-orientation="vertical" aria-labelledby="lang-menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    <a href="{{ route('lang.switch', 'en') }}" class="text-slate-700 dark:text-slate-200 block px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-700" role="menuitem">English</a>
                                    <a href="{{ route('lang.switch', 'id') }}" class="text-slate-700 dark:text-slate-200 block px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-700" role="menuitem">Indonesia</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- User Profile -->
                    <div class="relative group">
                        <button class="flex items-center gap-3 focus:outline-none" onclick="document.getElementById('user-dropdown').classList.toggle('hidden')">
                            <span class="text-sm font-medium hidden sm:block text-slate-600 dark:text-slate-300">{{ Auth::user()->name }}</span>
                            <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden border border-slate-300 dark:border-slate-600">
                                <img alt="User Avatar" class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=135bec&color=fff"/>
                            </div>
                        </button>
                        
                        <!-- Logout Dropdown -->
                        <div id="user-dropdown" class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-surface-dark rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none hidden group-hover:block z-50">
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
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <!-- Header & Search Section -->
        <section class="mb-10 space-y-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ __('Discover Movies') }}</h1>
                    <p class="text-slate-500 dark:text-slate-400">{{ __('Search through the Open Movie Database collection.') }}</p>
                </div>
            </div>
            
            <!-- Search Panel -->
            <form action="{{ route('movies.index') }}" method="GET" class="bg-white dark:bg-surface-dark p-4 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Title Input -->
                    <div class="md:col-span-6 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-icons-round text-slate-400">search</span>
                        </div>
                        <input type="text" name="s" value="{{ $keyword }}" class="block w-full pl-10 pr-3 py-2.5 bg-slate-50 dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-shadow" placeholder="{{ __('Search movie title (e.g. Batman)...') }}"/>
                    </div>
                    <!-- Year Select -->
                    <div class="md:col-span-2">
                        <select name="y" class="block w-full py-2.5 px-3 bg-slate-50 dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-shadow">
                            <option value="">{{ __('Year (All)') }}</option>
                            @for($i = date('Y'); $i >= 1950; $i--)
                                <option value="{{ $i }}" {{ (isset($year) && $year == $i) ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <!-- Type Select -->
                    <div class="md:col-span-2">
                        <select name="type" class="block w-full py-2.5 px-3 bg-slate-50 dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-shadow">
                            <option value="">{{ __('Type (All)') }}</option>
                            <option value="movie" {{ (isset($type) && $type == 'movie') ? 'selected' : '' }}>Movie</option>
                            <option value="series" {{ (isset($type) && $type == 'series') ? 'selected' : '' }}>Series</option>
                            <option value="episode" {{ (isset($type) && $type == 'episode') ? 'selected' : '' }}>Episode</option>
                        </select>
                    </div>
                    <!-- Search Button -->
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full h-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium py-2.5 px-4 rounded-lg transition-colors shadow-lg shadow-primary/25">
                            {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </form>
        </section>
        
        <!-- Stats / Results Info -->
        @if(isset($movies))
        <div class="flex items-center justify-between mb-6 text-sm text-slate-500 dark:text-slate-400">
            <span>{{ __('Showing results for') }} <strong class="text-slate-900 dark:text-white">"{{ $keyword }}"</strong></span>
            <div class="flex items-center gap-2">
                <span>{{ __('View') }}:</span>
                <button class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-700 text-primary">
                    <span class="material-icons-round text-xl">grid_view</span>
                </button>
            </div>
        </div>
        @endif
        
        <!-- Movie Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="movie-grid">
             @include('movies.partials.list', ['movies' => $movies, 'userFavorites' => $userFavorites])
        </div>
        
        <!-- Infinite Scroll Loader -->
        <div id="loading" class="mt-12 flex justify-center py-6" style="display: none;">
            <div class="flex items-center space-x-2 text-primary">
                <div class="w-2 h-2 rounded-full bg-primary animate-bounce"></div>
                <div class="w-2 h-2 rounded-full bg-primary animate-bounce delay-100"></div>
                <div class="w-2 h-2 rounded-full bg-primary animate-bounce delay-200"></div>
                <span class="ml-2 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Loading more titles...') }}</span>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 opacity-75">
                <span class="material-icons-round text-primary text-lg">movie</span>
                <span class="text-sm text-slate-600 dark:text-slate-400">© {{ date('Y') }} OMDBDash by Arya Isnaidi.</span>
            </div>
            <div class="flex items-center gap-6">
                <a class="text-sm text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">Privacy</a>
                <a class="text-sm text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">Terms</a>
                <a class="text-sm text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">API</a>
            </div>
        </div>
    </footer>

    <script>
        let page = 1;
        let keyword = "{{ $keyword ?? '' }}";
        let type = "{{ $type ?? '' }}";
        let year = "{{ $year ?? '' }}";
        let loading = false;
        let hasMore = true;

        function lazyLoadImages() {
            const images = document.querySelectorAll('.lazy-load');
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy-load');
                            observer.unobserve(img);
                        }
                    });
                });

                images.forEach(img => {
                    observer.observe(img);
                });
            } else {
                images.forEach(img => {
                    img.src = img.dataset.src;
                });
            }
        }

        $(window).scroll(function() {
            if (!keyword || !hasMore) return;
            
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !loading) {
                loading = true;
                $('#loading').css('display', 'flex'); // Flex to match user design CSS
                page++;
                
                $.ajax({
                    url: "{{ route('movies.index') }}",
                    data: {
                        s: keyword,
                        type: type,
                        y: year,
                        page: page
                    },
                    success: function(data) {
                        if ($.trim(data)) {
                            $('#movie-grid').append(data);
                            lazyLoadImages();
                        } else {
                            hasMore = false;
                        }
                        loading = false;
                        $('#loading').hide();
                    },
                    error: function() {
                        loading = false;
                        $('#loading').hide();
                        hasMore = false;
                    }
                });
            }
        });

        $(document).ready(function() {
            lazyLoadImages();
        });
    </script>
</body>
</html>
