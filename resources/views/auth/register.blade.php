<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Register Screen - Movie App</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        /* Custom styles for subtle background pattern */
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(19, 91, 236, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-white antialiased min-h-screen flex flex-col relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-grid-pattern pointer-events-none z-0"></div>
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-primary/20 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-primary/10 blur-[100px]"></div>
    </div>
    
    <!-- Navigation / Top Bar -->
    <nav class="relative z-10 w-full px-8 py-6 flex justify-between items-center">
        <!-- Logo Area -->
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary to-blue-400 flex items-center justify-center shadow-lg shadow-primary/30">
                <span class="material-icons text-white text-sm">movie</span>
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">OMDB<span class="text-primary">App</span></span>
        </div>
        <!-- Language Toggle -->
        <div class="flex items-center gap-2 bg-white dark:bg-slate-800/50 backdrop-blur-sm p-1 rounded-lg border border-slate-200 dark:border-slate-700">
             <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1 rounded text-xs font-semibold {{ app()->getLocale() == 'en' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-primary' }} transition-all">EN</a>
            <a href="{{ route('lang.switch', 'id') }}" class="px-3 py-1 rounded text-xs font-semibold {{ app()->getLocale() == 'id' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-primary' }} transition-all">ID</a>
        </div>
    </nav>
    
    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Side: Register Card -->
            <div class="w-full max-w-md mx-auto lg:mx-0">
                <div class="bg-white dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl p-8 relative overflow-hidden group">
                    <!-- Decorative top border gradient -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="mb-8 text-center lg:text-left">
                        <h1 class="text-2xl lg:text-3xl font-bold mb-2">Start Your Journey</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Create an account to access thousands of movies via the OMDB database.</p>
                    </div>
                    
                    <form class="space-y-5" method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1" for="fullname">Full Name</label>
                            <div class="relative">
                                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person</span>
                                <input autofocus="" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-slate-400 dark:text-white @error('name') border-red-500 @enderror" id="fullname" name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" type="text" required autocomplete="name"/>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1" for="email">Email Address</label>
                            <div class="relative">
                                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">mail</span>
                                <input class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-slate-400 dark:text-white @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" type="email" required autocomplete="email"/>
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Username -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1" for="username">Username</label>
                            <div class="relative">
                                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">alternate_email</span>
                                <input class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-slate-400 dark:text-white @error('username') border-red-500 @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="choose_username" type="text" required autocomplete="username"/>
                            </div>
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Passwords Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Password -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1" for="password">Password</label>
                                <div class="relative group/pass">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within/pass:text-primary transition-colors">lock</span>
                                    <input class="w-full pl-10 pr-10 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-slate-400 dark:text-white @error('password') border-red-500 @enderror" id="password" name="password" placeholder="••••••••" type="password" required autocomplete="new-password"/>
                                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors" type="button" onclick="togglePasswordVisibility('password')">
                                        <span class="material-icons text-lg">visibility</span>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1" for="confirm_password">Confirm</label>
                                <div class="relative group/pass-confirm">
                                    <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within/pass-confirm:text-primary transition-colors">lock_reset</span>
                                    <input class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-slate-400 dark:text-white" id="confirm_password" name="password_confirmation" placeholder="••••••••" type="password" required autocomplete="new-password"/>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button class="w-full py-3 px-4 bg-primary hover:bg-blue-600 text-white font-semibold rounded-lg shadow-lg shadow-primary/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm mt-6 flex justify-center items-center gap-2 group" type="submit">
                            <span>Create Account</span>
                            <span class="material-icons text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </form>
                    
                    <!-- Footer -->
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Already have an account? 
                            <a class="text-primary hover:text-blue-400 font-semibold transition-colors inline-flex items-center gap-1 group" href="{{ route('login') }}">
                                Back to Login
                                <span class="material-icons text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Cinematic Visual (Desktop only) -->
            <div class="hidden lg:block relative h-full min-h-[600px] w-full">
                <!-- Abstract Movie Poster Collage / Visual -->
                <div class="absolute inset-0 rounded-3xl overflow-hidden shadow-2xl border border-slate-800/50">
                    <img alt="Cinematic dark movie theater seats perspective" class="w-full h-full object-cover opacity-60 hover:scale-105 transition-transform duration-[20s]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFti2dvX16rpLmpx6OQfiEV9PL7Cy3SqkCHhka03uSbVTVms6EFq86ZFKdmZj8_Z84c2Lhh0q5jGBm2Upu1lH44mzfUFYG_KAWIL28Bp4tAA0SgFYhl4GP2eP0EkBdiXfm4_IhvNb2wKF4wm5Cg-_U1T7MEql9SiT4IckSQNFDoTGoMVhbWJzgZ_vIXvO_OSYSFvOan5nxsBs0BfjueNTr5QB8DhOw2Y4pXP3Y9rsKIzasvR3fnvRPBUsXpx0XV6b2pQ_VhL4r0n_s"/>
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/80 to-transparent"></div>
                    
                    <!-- Floating Elements -->
                    <div class="absolute bottom-12 left-8 right-8 text-white z-10">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-bold rounded border border-yellow-500/30">IMDb 8.9</span>
                            <span class="px-2 py-1 bg-primary/20 text-primary text-xs font-bold rounded border border-primary/30">Top Rated</span>
                        </div>
                        <h2 class="text-4xl font-bold leading-tight mb-3">Discover Cinema<br/>Like Never Before.</h2>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-sm">Join our community of film enthusiasts. Search, rate, and curate your personal movie collections using the world's most popular movie database API.</p>
                        
                        <!-- Mini Features -->
                        <div class="flex gap-6 mt-8">
                            <div class="flex flex-col">
                                <span class="text-2xl font-bold text-white">25k+</span>
                                <span class="text-xs text-slate-500 uppercase tracking-wider">Movies</span>
                            </div>
                             <div class="flex flex-col">
                                <span class="text-2xl font-bold text-white">100%</span>
                                <span class="text-xs text-slate-500 uppercase tracking-wider">Free Access</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Simple Footer Copyright -->
    <footer class="relative z-10 w-full text-center py-4 text-xs text-slate-600 dark:text-slate-500">
        © 2023 OMDB Movie App. All rights reserved.
    </footer>

    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
