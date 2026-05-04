<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Manage all pastes</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('pastes.index')); ?>" class="text-sm text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-1">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                View Site
            </a>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-sm text-red-600 hover:text-red-800 transition-colors font-medium">
                    Logout
                </button>
            </form>
        </div>
    </div>

    
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm font-medium text-gray-500">Total Pastes</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($stats['total']); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm font-medium text-gray-500">Public</p>
            <p class="text-2xl font-bold text-green-600 mt-1"><?php echo e($stats['public']); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm font-medium text-gray-500">Private</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1"><?php echo e($stats['private']); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm font-medium text-gray-500">Unlisted</p>
            <p class="text-2xl font-bold text-purple-600 mt-1"><?php echo e($stats['unlisted']); ?></p>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="<?php echo e(route('admin.dashboard')); ?>" method="GET" class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="flex-1">
                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="<?php echo e($search); ?>"
                    placeholder="Title or content..."
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >
            </div>
            <div>
                <label for="visibility" class="block text-xs font-medium text-gray-600 mb-1">Visibility</label>
                <select
                    name="visibility"
                    id="visibility"
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >
                    <option value="all" <?php echo e($visibility === 'all' ? 'selected' : ''); ?>>All</option>
                    <option value="public" <?php echo e($visibility === 'public' ? 'selected' : ''); ?>>Public</option>
                    <option value="private" <?php echo e($visibility === 'private' ? 'selected' : ''); ?>>Private</option>
                    <option value="unlisted" <?php echo e($visibility === 'unlisted' ? 'selected' : ''); ?>>Unlisted</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select
                    name="status"
                    id="status"
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >
                    <option value="all" <?php echo e($status === 'all' ? 'selected' : ''); ?>>All</option>
                    <option value="active" <?php echo e($status === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="expired" <?php echo e($status === 'expired' ? 'selected' : ''); ?>>Expired</option>
                    <option value="burned" <?php echo e($status === 'burned' ? 'selected' : ''); ?>>Burned</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                    Filter
                </button>
                <?php if($visibility !== 'all' || $status !== 'all' || $search): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 transition-colors inline-flex items-center">
                        Clear
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    
    <div class="flex justify-end">
        <form action="<?php echo e(route('admin.pastes.expired.delete')); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete ALL expired and burned pastes? This action cannot be undone.');">
            <?php echo csrf_field(); ?>
            <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors inline-flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete All Expired
            </button>
        </form>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <?php if($pastes->isEmpty()): ?>
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No pastes found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or create a new paste.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Language</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Visibility</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Expiry</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Views</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php $__currentLoopData = $pastes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a
                                        href="<?php echo e(route('pastes.show', $paste->slug)); ?>"
                                        target="_blank"
                                        class="text-sm font-mono text-indigo-600 hover:text-indigo-800 hover:underline"
                                        title="View paste"
                                    >
                                        <?php echo e(\Illuminate\Support\Str::limit($paste->slug, 10)); ?>

                                    </a>
                                </td>

                                
                                <td class="px-4 py-3 max-w-[200px]">
                                    <span class="text-sm text-gray-900 truncate block" title="<?php echo e($paste->title); ?>">
                                        <?php echo e(\Illuminate\Support\Str::limit($paste->title ?: '(untitled)', 40)); ?>

                                    </span>
                                </td>

                                
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="badge badge-language text-xs">
                                        <?php echo e($paste->language); ?>

                                    </span>
                                </td>

                                
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="badge badge-<?php echo e($paste->visibility); ?> text-xs">
                                        <?php echo e(ucfirst($paste->visibility)); ?>

                                    </span>
                                </td>

                                
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php if($paste->hasBurned()): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                            Burned
                                        </span>
                                    <?php elseif($paste->isExpired()): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800">
                                            Expired
                                        </span>
                                    <?php elseif($paste->expires_at): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800" title="<?php echo e($paste->expires_at->toDateTimeString()); ?>">
                                            <?php echo e($paste->expires_at->diffForHumans(null, true)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                            Never
                                        </span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500" title="<?php echo e($paste->created_at->toDateTimeString()); ?>">
                                    <?php echo e($paste->created_at->diffForHumans()); ?>

                                </td>

                                
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-500">
                                    <?php echo e(number_format($paste->views_count)); ?>

                                </td>

                                
                                <td class="px-4 py-3 whitespace-nowrap text-right">
                                    <form
                                        action="<?php echo e(route('admin.pastes.destroy', $paste->slug)); ?>"
                                        method="POST"
                                        onsubmit="return confirm('Delete paste \'<?php echo e(addslashes($paste->slug)); ?>\'? This action cannot be undone.');"
                                        class="inline"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                <?php echo e($pastes->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/workplace/8c6e71eb-7966-45a0-92f9-345b219e3a2e/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>