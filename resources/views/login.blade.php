@extends('index')

@section('auth')
    <div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full space-y-8">
            <div class="text-center">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-library-big">
                        <rect width="8" height="18" x="3" y="3" rx="1" />
                        <path d="M7 3v18" />
                        <path
                            d="M20.4 18.9c.2.5-.1 1.1-.6 1.3l-1.9.7c-.5.2-1.1-.1-1.3-.6L11.1 5.1c-.2-.5.1-1.1.6-1.3l1.9-.7c.5-.2 1.1.1 1.3.6Z" />
                    </svg>
                </div>

                <h2 class="mt-2 text-center text-3xl font-bold text-white">
                    Log in to your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Enter your email and password below to log in
                </p>
            </div>

            <form class="mt-6 space-y-4" action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 py-1">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}"
                        class="appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                        placeholder="email@example.com">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
              
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 py-1">Password</label>
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                class="appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                                placeholder="••••••••">
                            <div id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" id="eyeIcon">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                                    </path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </div>
                        </div>

                        @error('password')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">

                    @if (session('success'))
                        <p class="text-green-500 text-sm">{{ session('success') }}</p>
                    @endif
                </div>

                @if (session('error'))
                    <p class="text-red-500 text-sm text-center">{{ session('error') }}</p>
                @endif

                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-black bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-zinc-900">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                // Toggle password visibility
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    // Change to eye icon (password visible)
                    eyeIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
                } else {
                    passwordInput.type = 'password';
                    // Change to eye-off icon (password hidden)
                    eyeIcon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
                }
            });
        });
    </script>
@endsection
