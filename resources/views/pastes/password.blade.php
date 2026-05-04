@extends('layouts.app')

@section('title', 'Password Protected')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            {{-- Lock Icon --}}
            <div class="flex justify-center mb-6">
                <div class="rounded-full bg-amber-100 p-4">
                    <svg class="h-10 w-10 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            {{-- Heading --}}
            <h2 class="text-xl font-bold text-gray-900 text-center">
                This paste is password protected
            </h2>
            <p class="mt-2 text-sm text-gray-500 text-center">
                Enter the password to view this paste.
            </p>

            {{-- Error Message --}}
            @if (session('error'))
                <div class="mt-4 alert alert-error">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Password Form --}}
            <form action="{{ route('pastes.password.submit', $paste->slug) }}" method="POST" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="password" class="form-label sr-only">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Enter password"
                        required
                        autofocus
                        class="form-input text-center text-lg tracking-widest"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Unlock Paste
                </button>
            </form>
        </div>

        {{-- Back Link --}}
        <div class="mt-6 text-center">
            <a href="{{ route('pastes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
                Back to home
            </a>
        </div>
    </div>
</div>
@endsection
