@extends('layouts.app')

@section('title', 'Paste Expired')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="max-w-md text-center">
        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="rounded-full bg-gray-100 p-4">
                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Heading --}}
        <h1 class="text-3xl font-bold text-gray-900">
            This paste has expired or been burned.
        </h1>
        <p class="mt-3 text-gray-500">
            The paste you're looking for is no longer available. It may have reached its expiration time or was set to burn after reading.
        </p>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('pastes.create') }}" class="btn btn-primary w-full sm:w-auto">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create New Paste
            </a>
            <a href="{{ route('pastes.index') }}" class="btn btn-secondary w-full sm:w-auto">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
