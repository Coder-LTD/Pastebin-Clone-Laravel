@extends('layouts.app')

@section('title', $paste->title ?: 'Untitled Paste')

@section('content')
<div>
    {{-- Header Row --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">
                {{ $paste->title ?: 'Untitled Paste' }}
            </h1>
            <div class="mt-2 flex items-center gap-3 flex-wrap">
                {{-- Language Badge --}}
                <span class="badge badge-language">
                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    {{ ucfirst($paste->language ?? 'plaintext') }}
                </span>

                {{-- Visibility Badge --}}
                @if($paste->visibility === 'public')
                    <span class="badge badge-public">
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Public
                    </span>
                @elseif($paste->visibility === 'private')
                    <span class="badge badge-private">
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Private
                    </span>
                @elseif($paste->visibility === 'unlisted')
                    <span class="badge badge-unlisted">
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 01-4.243 4.243M6.343 6.343L17.657 17.657" />
                        </svg>
                        Unlisted
                    </span>
                @endif

                {{-- Password Protected Indicator --}}
                @if($paste->password)
                    <span class="badge bg-yellow-100 text-yellow-700">
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Password Protected
                    </span>
                @endif

                {{-- Created At --}}
                <span class="text-sm text-gray-400 flex items-center gap-1">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $paste->created_at->format('M d, Y \a\t h:i A') }}
                </span>

                {{-- Expiry Info --}}
                @if($paste->expires_at)
                    <span class="text-sm text-orange-500 flex items-center gap-1">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Expires {{ $paste->expires_at->diffForHumans() }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Action Buttons Bar --}}
    <div class="flex items-center gap-2 mb-4 p-3 bg-gray-800 rounded-lg">
        {{-- Copy Button --}}
        <button
            type="button"
            data-copy="#paste-content"
            class="copy-btn"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            Copy
        </button>

        {{-- Raw Button --}}
        <a href="{{ route('pastes.raw', $paste->slug) }}"
            class="btn btn-sm bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            Raw
        </a>
    </div>

    {{-- Code Block --}}
    <div class="code-block-wrapper">
        <pre class="!m-0"><code id="paste-content" class="language-{{ $paste->language ?? 'plaintext' }} hljs text-sm !p-6">{{ $paste->content }}</code></pre>
    </div>

    {{-- Share URL Section --}}
    <div class="mt-8 bg-white rounded-lg border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Share this paste</h3>
        <div class="flex gap-2">
            <input
                type="text"
                readonly
                value="{{ route('pastes.show', $paste->slug) }}"
                class="form-input flex-1 bg-gray-50 text-sm font-mono"
                id="share-url"
            >
            <button
                type="button"
                data-copy="#share-url"
                class="btn btn-secondary btn-sm flex-shrink-0"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Copy
            </button>
        </div>
    </div>
</div>
@endsection
