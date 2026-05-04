@extends('layouts.app')

@section('title', 'New Paste')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create New Paste</h1>
        <p class="mt-1 text-sm text-gray-500">Share your code snippet with syntax highlighting and optional password protection.</p>
    </div>

    {{-- Form --}}
    <form action="{{ route('pastes.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="form-label">Title <span class="text-gray-400 font-normal">(optional)</span></label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title') }}"
                placeholder="Untitled Paste"
                maxlength="255"
                class="form-input @error('title') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
            >
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Content --}}
        <div>
            <label for="content" class="form-label">
                Content
                <span class="text-red-500">*</span>
            </label>
            <textarea
                name="content"
                id="content"
                rows="16"
                placeholder="Paste your code here..."
                required
                class="form-textarea @error('content') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
            >{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-400">Required field. Paste your code or text content.</p>
        </div>

        {{-- Language & Expiry Row --}}
        <div class="grid gap-6 sm:grid-cols-2">
            {{-- Language --}}
            <div>
                <label for="language" class="form-label">Language</label>
                <select
                    name="language"
                    id="language"
                    class="form-select @error('language') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
                >
                    <option value="plaintext" {{ old('language') === 'plaintext' ? 'selected' : '' }}>Plain Text</option>
                    <option value="php" {{ old('language') === 'php' ? 'selected' : '' }}>PHP</option>
                    <option value="javascript" {{ old('language') === 'javascript' ? 'selected' : '' }}>JavaScript</option>
                    <option value="typescript" {{ old('language') === 'typescript' ? 'selected' : '' }}>TypeScript</option>
                    <option value="python" {{ old('language') === 'python' ? 'selected' : '' }}>Python</option>
                    <option value="ruby" {{ old('language') === 'ruby' ? 'selected' : '' }}>Ruby</option>
                    <option value="java" {{ old('language') === 'java' ? 'selected' : '' }}>Java</option>
                    <option value="csharp" {{ old('language') === 'csharp' ? 'selected' : '' }}>C#</option>
                    <option value="cpp" {{ old('language') === 'cpp' ? 'selected' : '' }}>C++</option>
                    <option value="go" {{ old('language') === 'go' ? 'selected' : '' }}>Go</option>
                    <option value="rust" {{ old('language') === 'rust' ? 'selected' : '' }}>Rust</option>
                    <option value="html" {{ old('language') === 'html' ? 'selected' : '' }}>HTML</option>
                    <option value="css" {{ old('language') === 'css' ? 'selected' : '' }}>CSS</option>
                    <option value="json" {{ old('language') === 'json' ? 'selected' : '' }}>JSON</option>
                    <option value="yaml" {{ old('language') === 'yaml' ? 'selected' : '' }}>YAML</option>
                    <option value="sql" {{ old('language') === 'sql' ? 'selected' : '' }}>SQL</option>
                    <option value="bash" {{ old('language') === 'bash' ? 'selected' : '' }}>Bash</option>
                </select>
                @error('language')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Expiry --}}
            <div>
                <label for="expires_at" class="form-label">Expires</label>
                <select
                    name="expires_at"
                    id="expires_at"
                    class="form-select @error('expires_at') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
                >
                    <option value="burn" {{ old('expires_at') === 'burn' ? 'selected' : '' }}>🔥 Burn After Read</option>
                    <option value="1h" {{ old('expires_at') === '1h' ? 'selected' : '' }}>1 Hour</option>
                    <option value="1d" {{ old('expires_at') === '1d' ? 'selected' : '' }}>1 Day</option>
                    <option value="1w" {{ old('expires_at') === '1w' ? 'selected' : '' }}>1 Week</option>
                    <option value="never" {{ old('expires_at', 'never') === 'never' ? 'selected' : '' }}>Never</option>
                </select>
                @error('expires_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Visibility --}}
        <div>
            <label class="form-label">Visibility</label>
            <div class="mt-2 flex flex-wrap gap-4">
                <label class="form-radio-group cursor-pointer">
                    <input
                        type="radio"
                        name="visibility"
                        value="public"
                        {{ old('visibility', 'public') === 'public' ? 'checked' : '' }}
                        class="form-radio"
                    >
                    <div class="ml-2">
                        <span class="text-sm font-medium text-gray-700">Public</span>
                        <p class="text-xs text-gray-400">Visible to everyone</p>
                    </div>
                </label>
                <label class="form-radio-group cursor-pointer">
                    <input
                        type="radio"
                        name="visibility"
                        value="unlisted"
                        {{ old('visibility') === 'unlisted' ? 'checked' : '' }}
                        class="form-radio"
                    >
                    <div class="ml-2">
                        <span class="text-sm font-medium text-gray-700">Unlisted</span>
                        <p class="text-xs text-gray-400">Only with direct link</p>
                    </div>
                </label>
                <label class="form-radio-group cursor-pointer">
                    <input
                        type="radio"
                        name="visibility"
                        value="private"
                        {{ old('visibility') === 'private' ? 'checked' : '' }}
                        class="form-radio"
                    >
                    <div class="ml-2">
                        <span class="text-sm font-medium text-gray-700">Private</span>
                        <p class="text-xs text-gray-400">Password protected</p>
                    </div>
                </label>
            </div>
            @error('visibility')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div id="password-field">
            <label for="password" class="form-label">
                Password
                <span class="text-gray-400 font-normal">(optional)</span>
            </label>
            <div class="relative">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Enter a password to protect this paste"
                    class="form-input pr-20 @error('password') border-red-400 focus:border-red-500 focus:ring-red-200 @enderror"
                >
                <button
                    type="button"
                    data-password-toggle="#password"
                    class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex items-center gap-1 rounded-md px-2.5 py-1 text-xs font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>Show</span>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-400">Set a password to restrict access. Leave empty for no password.</p>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
            <a href="{{ route('pastes.index') }}" class="btn btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary btn-lg">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Paste
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Show/hide password field based on visibility selection
    document.addEventListener('DOMContentLoaded', () => {
        const visibilityInputs = document.querySelectorAll('input[name="visibility"]');
        const passwordField = document.getElementById('password-field');

        function togglePasswordField() {
            const selected = document.querySelector('input[name="visibility"]:checked');
            if (selected && selected.value === 'public') {
                passwordField.style.opacity = '0.5';
                passwordField.style.pointerEvents = 'none';
                document.getElementById('password').value = '';
            } else {
                passwordField.style.opacity = '1';
                passwordField.style.pointerEvents = 'auto';
            }
        }

        visibilityInputs.forEach(input => input.addEventListener('change', togglePasswordField));
        togglePasswordField();
    });
</script>
@endsection
