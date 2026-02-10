<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ __('Login') }} - Movie App</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Configuration -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "primary-dark": "#0e45b5",
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
        /* Custom styles for autofill to match dark theme */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #1f2937 inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-800 dark:text-white antialiased h-screen w-full overflow-hidden flex items-center justify-center relative">
    <!-- Cinematic Background with Overlay -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-background-dark/80 backdrop-blur-sm z-10"></div>
        <img alt="Cinematic movie theater background" class="w-full h-full object-cover" data-alt="Abstract dark cinema theater background with red seats" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAHmnzPaNxJT5yqe9hrqYiGJDbbgDkwcVQmrUl6LERU72pCsoOzgPeGeQH6dLoTrR6q43FqGKtiRcEuL2bu9H4KWyFTEkEIz8OuSWtIFsRS1tdOIiofOChTv5NokAgQ9fYQj1vjfvGobcAqKo7bprO0YzyOpT5yOclHJe8c-TfYd2TyVX4JwZ3CyzUBflp4YVEzd_47UlYRHiu9gUCGxJF1LUxYal2LCjPPb4IFhObsRDezrcgxPp-o0r9wmc-BKtoUDkfsebMZE-QD"/>
    </div>
    
    <!-- Language Toggle (Top Right) -->
    <div class="absolute top-6 right-6 z-20 flex items-center gap-2 bg-slate-800/50 backdrop-blur-md rounded-full p-1 border border-slate-700">
        <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1 text-xs font-semibold rounded-full transition-all duration-300 {{ app()->getLocale() == 'en' ? 'bg-primary text-white shadow-lg' : 'text-slate-400 hover:text-white' }}">EN</a>
        <a href="{{ route('lang.switch', 'id') }}" class="px-3 py-1 text-xs font-semibold rounded-full transition-all duration-300 {{ app()->getLocale() == 'id' ? 'bg-primary text-white shadow-lg' : 'text-slate-400 hover:text-white' }}">ID</a>
    </div>

    <!-- Login Card -->
    <main class="relative z-20 w-full max-w-md px-4">
        <div class="bg-slate-900/90 dark:bg-[#1A2233]/95 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-2xl p-8 md:p-10">
            <!-- Logo Area -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary/20 text-primary mb-4">
                    <span class="material-icons text-3xl">movie_filter</span>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">{{ __('Welcome Back') }}</h1>
                <p class="text-slate-400 text-sm">{{ __('Sign in to access the OMDB Movie Database') }}</p>
            </div>
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Username Field -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-300" for="username">{{ __('Username') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 group-focus-within:text-primary transition-colors">
                            <span class="material-icons text-xl">person</span>
                        </div>
                        <input class="block w-full pl-10 pr-3 py-3 bg-slate-800 border {{ $errors->has('username') ? 'border-red-500' : 'border-slate-700' }} rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm transition-all duration-200" 
                               id="username" name="username" value="{{ old('username') }}" placeholder="{{ __('Enter your username') }}" type="text" required autofocus />
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-medium text-slate-300" for="password">{{ __('Password') }}</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 group-focus-within:text-primary transition-colors">
                            <span class="material-icons text-xl">lock</span>
                        </div>
                        <input class="block w-full pl-10 pr-10 py-3 bg-slate-800 border {{ $errors->has('password') ? 'border-red-500' : 'border-slate-700' }} rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm transition-all duration-200" 
                               id="password" name="password" placeholder="••••••••" type="password" required />
                        <!-- Password Visibility Toggle (Simple impl) -->
                        <button onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none" type="button">
                            <span class="material-icons text-xl" id="toggleIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password Link -->
                <div class="flex justify-between items-center">
                     <div class="form-check">
                        <input class="form-check-input rounded bg-slate-800 border-slate-700 text-primary focus:ring-primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-sm text-slate-400 ml-2" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a class="text-sm text-primary hover:text-primary-light transition-colors font-medium" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>

                <!-- Error Message -->
                @if($errors->any())
                    <div class="p-3 bg-red-500/10 border border-red-500/20 rounded-lg flex items-center gap-2 text-red-400 text-sm animate-pulse" id="error-message">
                        <span class="material-icons text-base">error_outline</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Submit Button -->
                <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-primary transition-all duration-200 transform hover:-translate-y-0.5" type="submit">
                    {{ __('Login') }}
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-[#1A2233] text-slate-500">{{ __('Or continue with') }}</span>
                </div>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <button type="button" class="flex items-center justify-center px-4 py-2 border border-slate-700 rounded-lg bg-slate-800/50 hover:bg-slate-700 text-white transition-colors duration-200 text-sm font-medium">
                    <svg aria-hidden="true" class="h-5 w-5 mr-2" fill="currentColor" viewbox="0 0 24 24">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"></path>
                    </svg>
                    Google
                </button>
                <button type="button" class="flex items-center justify-center px-4 py-2 border border-slate-700 rounded-lg bg-slate-800/50 hover:bg-slate-700 text-white transition-colors duration-200 text-sm font-medium">
                    <svg aria-hidden="true" class="h-5 w-5 mr-2" fill="currentColor" viewbox="0 0 24 24">
                        <path clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" fill-rule="evenodd"></path>
                    </svg>
                    GitHub
                </button>
            </div>
            
            <!-- Footer Text -->
            <p class="text-center text-sm text-slate-400">
                {{ __('Don\'t have an account?') }} 
                @if (Route::has('register'))
                    <a class="font-semibold text-primary hover:text-primary-light transition-colors" href="{{ route('register') }}">{{ __('Register') }}</a>
                @else
                    <a class="font-semibold text-primary hover:text-primary-light transition-colors" href="#">{{ __('Register') }}</a>
                @endif
            </p>
        </div>
    </main>
    
    <!-- Footer Copyright -->
    <footer class="absolute bottom-4 z-20 w-full text-center">
        <p class="text-xs text-slate-500">© {{ date('Y') }} OMDB Movie App by Arya Isnaidi. All rights reserved.</p>
    </footer>

    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            var icon = document.getElementById("toggleIcon");
            if (x.type === "password") {
                x.type = "text";
                icon.innerText = "visibility_off";
            } else {
                x.type = "password";
                icon.innerText = "visibility";
            }
        }
    </script>
</body>
</html>
