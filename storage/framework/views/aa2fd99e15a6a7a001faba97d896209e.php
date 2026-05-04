<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<div>
    
    <div class="relative overflow-hidden rounded-2xl bg-gray-900 mb-10">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-purple-600/20"></div>
        <div class="relative px-6 py-16 sm:px-12 sm:py-20 lg:py-24 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Share Code Snippets Instantly
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-300">
                Paste, share, and collaborate on code snippets. Syntax highlighting, expiring pastes, and password protection — all in one place.
            </p>
            <div class="mt-8">
                <a href="<?php echo e(route('pastes.create')); ?>" class="btn btn-primary btn-lg shadow-xl">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Paste
                </a>
            </div>
        </div>
    </div>

    
    <?php if($pastes->count() > 0): ?>
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Recent Pastes</h2>
            <p class="mt-1 text-sm text-gray-500"><?php echo e($pastes->total()); ?> paste<?php echo e($pastes->total() !== 1 ? 's' : ''); ?> shared</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $pastes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('pastes.show', $paste->slug)); ?>" class="paste-card p-5 block group">
                    
                    <h3 class="font-semibold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">
                        <?php echo e($paste->title ?: 'Untitled'); ?>

                    </h3>

                    
                    <p class="mt-2 text-sm text-gray-500 line-clamp-2 font-mono">
                        <?php if($paste->title): ?>
                            <?php echo e(\Illuminate\Support\Str::limit($paste->content, 80)); ?>

                        <?php else: ?>
                            <?php echo e(\Illuminate\Support\Str::limit($paste->content, 80)); ?>

                        <?php endif; ?>
                    </p>

                    
                    <div class="mt-4 flex items-center gap-2 flex-wrap">
                        
                        <span class="badge badge-language">
                            <?php echo e(ucfirst($paste->language ?? 'plaintext')); ?>

                        </span>

                        
                        <?php if($paste->visibility === 'public'): ?>
                            <span class="badge badge-public">
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Public
                            </span>
                        <?php elseif($paste->visibility === 'private'): ?>
                            <span class="badge badge-private">
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Private
                            </span>
                        <?php elseif($paste->visibility === 'unlisted'): ?>
                            <span class="badge badge-unlisted">
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 01-4.243 4.243M6.343 6.343L17.657 17.657" />
                                </svg>
                                Unlisted
                            </span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="mt-3 flex items-center text-xs text-gray-400">
                        <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?php echo e($paste->created_at->diffForHumans()); ?>

                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="mt-8">
            <?php echo e($pastes->links()); ?>

        </div>
    <?php else: ?>
        
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-4 text-lg font-semibold text-gray-900">No pastes yet</h3>
            <p class="mt-2 text-sm text-gray-500">Be the first to share a code snippet!</p>
            <div class="mt-6">
                <a href="<?php echo e(route('pastes.create')); ?>" class="btn btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create One!
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/workplace/8c6e71eb-7966-45a0-92f9-345b219e3a2e/resources/views/pastes/index.blade.php ENDPATH**/ ?>