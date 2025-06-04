@extends('index')

@section('auth')
<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-sm w-full space-y-8">
        <div class="text-center">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-library-big">
                    <rect width="8" height="18" x="3" y="3" rx="1"/>
                    <path d="M7 3v18"/>
                    <path d="M20.4 18.9c.2.5-.1 1.1-.6 1.3l-1.9.7c-.5.2-1.1-.1-1.3-.6L11.1 5.1c-.2-.5.1-1.1.6-1.3l1.9-.7c.5-.2 1.1.1 1.3.6Z"/>
                </svg>
            </div>
            
            <h2 class="mt-2 text-center text-3xl font-bold text-white">
                Change your password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Enter your current password and set a new one
            </p>
        </div>
        
        @if(session('status'))
            <div class="bg-green-900 border border-green-800 text-green-100 px-4 py-3 rounded-md relative mt-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900 border border-red-800 text-red-100 px-4 py-3 rounded-md relative mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        <form id="passwordForm" class="mt-6 space-y-4" action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-300">Current password</label>
                <div class="relative mt-1">
                    <input id="current_password" name="current_password" type="password" 
                           class="appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm" 
                           placeholder="••••••••">
                    <div id="toggleCurrentPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIconCurrent">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </div>
                </div>
                @error('current_password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-300">New password</label>
                <div class="relative mt-1">
                    <input id="new_password" name="new_password" type="password" autocomplete="new-password"  
                           class="appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm" 
                           placeholder="••••••••">
                    <div id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </div>
                    @error('new_password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p id="passwordError" class="text-red-400 text-xs mt-1 hidden">Passwords do not match</p>
                </div>
            </div>
            
            <div>
                <label for="new_password_confirmed" class="block text-sm font-medium text-gray-300">Confirm new password</label>
                <div class="relative mt-1">
                    <input id="new_password_confirmed" name="new_password_confirmed" type="password"  
                           class="appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm" 
                           placeholder="••••••••">
                    <div id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIconConfirm">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </div>
                    <p id="confirmPasswordError" class="text-red-400 text-xs mt-1 hidden">Passwords do not match</p>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="submit w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-black bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-zinc-900">
                    Update password
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="/" class="text-sm font-medium text-gray-400 hover:text-white">
                    Cancel and return to profile
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle for current password
    const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
    const currentPasswordInput = document.getElementById('current_password');
    const eyeIconCurrent = document.getElementById('eyeIconCurrent');
    
    toggleCurrentPassword.addEventListener('click', function() {
        // Toggle password visibility
        if (currentPasswordInput.type === 'password') {
            currentPasswordInput.type = 'text';
            // Change to eye icon (password visible)
            eyeIconCurrent.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        } else {
            currentPasswordInput.type = 'password';
            // Change to eye-off icon (password hidden)
            eyeIconCurrent.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        }
    });

    // Toggle for new password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('new_password');
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
    
    // Toggle for confirmation password
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('new_password_confirmed');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');
    
    toggleConfirmPassword.addEventListener('click', function() {
        // Toggle password visibility
        if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            // Change to eye icon (password visible)
            eyeIconConfirm.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        } else {
            confirmPasswordInput.type = 'password';
            // Change to eye-off icon (password hidden)
            eyeIconConfirm.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        }
    });
    
    // Password matching validation
    const passwordErrorElem = document.getElementById('passwordError');
    const confirmPasswordErrorElem = document.getElementById('confirmPasswordError');
    const passwordForm = document.getElementById('passwordForm');
    const submitButton = document.querySelector('button.submit');
    
    // Function to check if passwords match
    function checkPasswordsMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (password === '' || confirmPassword === '') {
            passwordErrorElem.classList.add('hidden');
            confirmPasswordErrorElem.classList.add('hidden');
            return true;
        }
        
        if (password !== confirmPassword) {
            passwordErrorElem.classList.remove('hidden');
            confirmPasswordErrorElem.classList.remove('hidden');
            return false;
        } else {
            passwordErrorElem.classList.add('hidden');
            confirmPasswordErrorElem.classList.add('hidden');
            return true;
        }
    }
    
    // Add input event listeners to both password fields
    passwordInput.addEventListener('input', checkPasswordsMatch);
    confirmPasswordInput.addEventListener('input', checkPasswordsMatch);
    
    // Validate form before submission
    passwordForm.addEventListener('submit', function(event) {
        if (!checkPasswordsMatch()) {
            event.preventDefault();
        }
    });
});
</script>
@endsection