<?php $__env->startSection('title', 'Admin Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            
            <div class="bg-gray-900 px-6 py-4">
                <div class="flex items-center justify-center space-x-3">
                    <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h1 class="text-xl font-bold text-white">Admin Login</h1>
                </div>
            </div>

            
            <div class="px-6 py-8">
                <?php if(session('error')): ?>
                    <div class="mb-6 rounded-md bg-red-50 border border-red-200 p-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-red-700"><?php echo e(session('error')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('admin.login.submit')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autofocus
                            placeholder="Enter admin password"
                            class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition-colors text-sm"
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <button
                        type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Sign In
                    </button>
                </form>
            </div>

            
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                <a href="<?php echo e(route('pastes.index')); ?>" class="text-sm text-gray-500 hover:text-gray-700 transition-colors flex items-center justify-center gap-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/workplace/8c6e71eb-7966-45a0-92f9-345b219e3a2e/resources/views/admin/login.blade.php ENDPATH**/ ?>