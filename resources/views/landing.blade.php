@extends('index')

@section('landing')
<style>
   :root{
    background-color: black;
   }
   
    .image-container {
        height: 100%;
        display: flex;
        align-items: center;
    }
    
    .image-container img {
        object-fit: contain;
        max-height: 80vh;
        width: auto;
        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.3));
        opacity: 0;
        animation: fadeIn 1.5s ease-out 0.5s forwards;
    }
    
    .logo-container {
        opacity: 0;
        animation: fadeIn 1s ease-out 0s forwards;
    }
    
    .title {
        opacity: 0;
        animation: fadeIn 1s ease-out 0.2s forwards;
    }
    
    .subtitle {
        opacity: 0;
        animation: fadeIn 1s ease-out 0.4s forwards;
    }
    
    .buttons {
        opacity: 0;
        animation: fadeIn 1s ease-out 0.6s forwards;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="min-h-screen flex items-center justify-between bg-black py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto overflow-hidden">
    <div class="max-w-2xl">
        <div class="flex items-center mb-10 logo-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-library-big">
                <rect width="8" height="18" x="3" y="3" rx="1" />
                <path d="M7 3v18" />
                <path
                    d="M20.4 18.9c.2.5-.1 1.1-.6 1.3l-1.9.7c-.5.2-1.1-.1-1.3-.6L11.1 5.1c-.2-.5.1-1.1.6-1.3l1.9-.7c.5-.2 1.1.1 1.3.6Z" />
            </svg>
            <span class="ml-2 text-white text-xl">Lightshelf</span>
        </div>
        <h1 class="text-6xl font-bold text-white leading-tight title">Share and never forget what you read.</h1>
        <p class="text-xl text-gray-400 my-8 subtitle">Lightshelf is your book's related social media and own library allowing you to take notes and share it to the world</p>
        <div class="flex gap-5 mt-8 buttons">
            <a href="{{ route('showRegister') }}" class="px-6 py-3 bg-white text-black text-sm font-medium rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-zinc-900 transition">Sign up</a>
            <a href="{{ route('showLogin') }}" class="px-6 py-3 border border-zinc-700 text-white text-sm font-medium rounded-md hover:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-zinc-900 transition">Login</a>
        </div>
    </div>
    <div class="hidden md:flex image-container">
        <img src="{{ asset('images/mockup.png') }}" alt="Lightshelf App">
    </div>
</div>
@endsection