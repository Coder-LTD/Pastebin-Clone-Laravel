<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Pastebin'); ?> - <?php echo e(config('app.name', 'Pastebin')); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <?php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $cssFile = $manifest['resources/css/app.css']['file'] ?? 'assets/app.css';
        $jsFile = $manifest['resources/js/app.js']['file'] ?? 'assets/app.js';
    ?>
    <link rel="stylesheet" href="<?php echo e('/build/'.$cssFile); ?>">
    <script type="module" src="<?php echo e('/build/'.$jsFile); ?>"></script>
</head>
<body class="h-full bg-gray-50 antialiased font-sans flex flex-col">
    <!-- Navigation -->
    <nav class="bg-gray-900 shadow-lg flex-shrink-0">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Brand -->
                <div class="flex items-center">
                    <a href="<?php echo e(route('pastes.index')); ?>" class="flex items-center space-x-2">
                        <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-xl font-bold text-white tracking-tight">Pastebin</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('pastes.index')); ?>"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?php echo e(request()->routeIs('pastes.index') ? 'bg-gray-700 text-white' : ''); ?>">
                        Home
                    </a>
                    <a href="<?php echo e(route('pastes.create')); ?>"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition-colors <?php echo e(request()->routeIs('pastes.create') ? 'bg-gray-700 text-white' : ''); ?>">
                        New Paste
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if(session()->has('success')): ?>
        <div data-flash class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div class="alert alert-success flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?php echo e(session('success')); ?></span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div data-flash class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div class="alert alert-error flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?php echo e(session('error')); ?></span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session()->has('warning')): ?>
        <div data-flash class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div class="alert alert-warning flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <span><?php echo e(session('warning')); ?></span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-yellow-500 hover:text-yellow-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session()->has('info')): ?>
        <div data-flash class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div class="alert alert-info flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?php echo e(session('info')); ?></span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div data-flash class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div class="alert alert-error">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="ml-7 list-disc text-sm space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Page Content -->
    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 shadow-sm flex-shrink-0">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                <p class="text-sm text-gray-500">
                    &copy; <?php echo e(date('Y')); ?> <span class="font-semibold text-gray-700"><?php echo e(config('app.name', 'Pastebin')); ?></span>. All rights reserved.
                </p>
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('admin.login')); ?>" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        Admin
                    </a>
                    <span class="text-xs text-gray-300">|</span>
                    <p class="text-sm text-gray-400">
                        Built with <span class="text-red-500">&hearts;</span> using Laravel &amp; Tailwind CSS
                    </p>
                </div>
            </div>
        </div>
    </footer>

    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /app/workplace/8c6e71eb-7966-45a0-92f9-345b219e3a2e/resources/views/layouts/app.blade.php ENDPATH**/ ?>