<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AgriConnect Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'agri-green': {
                            light: '#6cb43c',
                            DEFAULT: '#4a8b2c',
                            dark: '#2d5e1a',
                        },
                        'agri-brown': {
                            light: '#d7ccc8',
                            DEFAULT: '#a1887f',
                            dark: '#795548',
                        }, 
                        'agri-beige': '#f5f5dc',
                        'agri-red': {
                            light: '#f8d7da',
                            DEFAULT: '#dc3545',
                            dark: '#842029',
                        }
                    }
                }
            },
            darkMode: 'class',
        }
        
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>
</head>
<body class="font-['Poppins',sans-serif] bg-gradient-to-br from-agri-beige to-white dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo and Header -->
        <div class="text-center mb-8">
            <div class="mx-auto bg-white dark:bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-agri-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-agri-green-dark dark:text-agri-green-light">AgriConnect</h1>
        </div>
        
        <!-- Login Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 border border-agri-brown-light dark:border-gray-700">
            <!-- Global Error Messages -->
            @if ($errors->any())
            <div class="mb-4 p-4 rounded-md bg-agri-red-light dark:bg-red-900 text-agri-red-dark dark:text-red-200 text-sm">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="font-medium">Il y a eu un soucis avec votre connexion :</p>
                        <ul class="list-disc list-inside mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            
            <form action="{{ route('login.submit') }}" method="post">
                @csrf
                <div class="space-y-6">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 @error('email') text-agri-red @else text-agri-brown dark:text-agri-brown-light @enderror" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="@error('email') ring-agri-red border-agri-red @else focus:ring-agri-green focus:border-agri-green border-agri-brown-light dark:border-gray-600 @enderror block w-full pl-10 sm:text-sm rounded-md py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                                   placeholder="your@email.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-agri-red dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 @error('password') text-agri-red @else text-agri-brown dark:text-agri-brown-light @enderror" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required 
                                   class="@error('password') ring-agri-red border-agri-red @else focus:ring-agri-green focus:border-agri-green border-agri-brown-light dark:border-gray-600 @enderror block w-full pl-10 sm:text-sm rounded-md py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                                   placeholder="••••••••">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" class="password-toggle text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none" tabindex="-1">
                                        <!-- Eye Icon (Show Password) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        <!-- Eye Slash Icon (Hide Password) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-slash-icon hidden" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-agri-red dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-agri-green focus:ring-agri-green border-agri-brown-light dark:border-gray-600 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Remember me
                            </label>
                        </div>
                        
                        
                    </div>
                    
                    <!-- Login Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-agri-green hover:bg-agri-green-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-agri-green transition-colors duration-200">
                            Connexion
                        </button>
                    </div>
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Vous n'avez pas de compte? 
                            <a href="{{ route('register') }}" class="font-medium text-agri-green hover:text-agri-green-dark dark:hover:text-agri-green-light">
                                S'inscrire
                            </a>
                        </p>
                    </div>
                </div>
            </form>
            
            <!-- Create Account Link -->
            
        </div>
        
        <!-- Session Status Message (for password reset confirmations, etc.) -->
        @if (session('status'))
        <div class="mt-4 rounded-md bg-green-50 dark:bg-green-900 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('status') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="mt-8 text-center">
            <div class="flex items-center justify-center space-x-4">
                <a href="#" class="text-agri-brown hover:text-agri-brown-dark dark:text-gray-400 dark:hover:text-white">
                    <span class="sr-only">Terms</span>
                    <span class="text-xs">Terms of Service</span>
                </a>
                <span class="text-agri-brown dark:text-gray-500">•</span>
                <a href="#" class="text-agri-brown hover:text-agri-brown-dark dark:text-gray-400 dark:hover:text-white">
                    <span class="sr-only">Privacy</span>
                    <span class="text-xs">Privacy Policy</span>
                </a>
                <span class="text-agri-brown dark:text-gray-500">•</span>
                <a href="#" class="text-agri-brown hover:text-agri-brown-dark dark:text-gray-400 dark:hover:text-white">
                    <span class="sr-only">Help</span>
                    <span class="text-xs">Help Center</span>
                </a>
            </div>
            <p class="mt-4 text-xs text-agri-brown dark:text-gray-400">© 2023 AgriConnect. All rights reserved.</p>
        </div>
    </div>
    <script>
        // Password visibility toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.password-toggle');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const passwordInput = this.closest('.relative').querySelector('input');
                    const eyeIcon = this.querySelector('.eye-icon');
                    const eyeSlashIcon = this.querySelector('.eye-slash-icon');
                    
                    // Toggle password visibility
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.classList.remove('hidden');
                        eyeSlashIcon.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>


 
