<?php $__env->startSection('title', 'New Paste'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create New Paste</h1>
        <p class="mt-1 text-sm text-gray-500">Share your code snippet with syntax highlighting and optional password protection.</p>
    </div>

    
    <form action="<?php echo e(route('pastes.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>

        
        <div>
            <label for="title" class="form-label">Title <span class="text-gray-400 font-normal">(optional)</span></label>
            <input
                type="text"
                name="title"
                id="title"
                value="<?php echo e(old('title')); ?>"
                placeholder="Untitled Paste"
                maxlength="255"
                class="form-input <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-500 focus:ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            >
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
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
                class="form-textarea <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-500 focus:ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            ><?php echo e(old('content')); ?></textarea>
            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <p class="mt-1 text-xs text-gray-400">Required field. Paste your code or text content.</p>
        </div>

        
        <div class="grid gap-6 sm:grid-cols-2">
            
            <div>
                <label for="language" class="form-label">Language</label>
                <select
                    name="language"
                    id="language"
                    class="form-select <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-500 focus:ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="plaintext" <?php echo e(old('language') === 'plaintext' ? 'selected' : ''); ?>>Plain Text</option>
                    <option value="php" <?php echo e(old('language') === 'php' ? 'selected' : ''); ?>>PHP</option>
                    <option value="javascript" <?php echo e(old('language') === 'javascript' ? 'selected' : ''); ?>>JavaScript</option>
                    <option value="typescript" <?php echo e(old('language') === 'typescript' ? 'selected' : ''); ?>>TypeScript</option>
                    <option value="python" <?php echo e(old('language') === 'python' ? 'selected' : ''); ?>>Python</option>
                    <option value="ruby" <?php echo e(old('language') === 'ruby' ? 'selected' : ''); ?>>Ruby</option>
                    <option value="java" <?php echo e(old('language') === 'java' ? 'selected' : ''); ?>>Java</option>
                    <option value="csharp" <?php echo e(old('language') === 'csharp' ? 'selected' : ''); ?>>C#</option>
                    <option value="cpp" <?php echo e(old('language') === 'cpp' ? 'selected' : ''); ?>>C++</option>
                    <option value="go" <?php echo e(old('language') === 'go' ? 'selected' : ''); ?>>Go</option>
                    <option value="rust" <?php echo e(old('language') === 'rust' ? 'selected' : ''); ?>>Rust</option>
                    <option value="html" <?php echo e(old('language') === 'html' ? 'selected' : ''); ?>>HTML</option>
                    <option value="css" <?php echo e(old('language') === 'css' ? 'selected' : ''); ?>>CSS</option>
                    <option value="json" <?php echo e(old('language') === 'json' ? 'selected' : ''); ?>>JSON</option>
                    <option value="yaml" <?php echo e(old('language') === 'yaml' ? 'selected' : ''); ?>>YAML</option>
                    <option value="sql" <?php echo e(old('language') === 'sql' ? 'selected' : ''); ?>>SQL</option>
                    <option value="bash" <?php echo e(old('language') === 'bash' ? 'selected' : ''); ?>>Bash</option>
                </select>
                <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="expires_at" class="form-label">Expires</label>
                <select
                    name="expires_at"
                    id="expires_at"
                    class="form-select <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-500 focus:ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="burn" <?php echo e(old('expires_at') === 'burn' ? 'selected' : ''); ?>>🔥 Burn After Read</option>
                    <option value="1h" <?php echo e(old('expires_at') === '1h' ? 'selected' : ''); ?>>1 Hour</option>
                    <option value="1d" <?php echo e(old('expires_at') === '1d' ? 'selected' : ''); ?>>1 Day</option>
                    <option value="1w" <?php echo e(old('expires_at') === '1w' ? 'selected' : ''); ?>>1 Week</option>
                    <option value="never" <?php echo e(old('expires_at', 'never') === 'never' ? 'selected' : ''); ?>>Never</option>
                </select>
                <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        
        <div>
            <label class="form-label">Visibility</label>
            <div class="mt-2 flex flex-wrap gap-4">
                <label class="form-radio-group cursor-pointer">
                    <input
                        type="radio"
                        name="visibility"
                        value="public"
                        <?php echo e(old('visibility', 'public') === 'public' ? 'checked' : ''); ?>

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
                        <?php echo e(old('visibility') === 'unlisted' ? 'checked' : ''); ?>

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
                        <?php echo e(old('visibility') === 'private' ? 'checked' : ''); ?>

                        class="form-radio"
                    >
                    <div class="ml-2">
                        <span class="text-sm font-medium text-gray-700">Private</span>
                        <p class="text-xs text-gray-400">Password protected</p>
                    </div>
                </label>
            </div>
            <?php $__errorArgs = ['visibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
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
                    class="form-input pr-20 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 focus:border-red-500 focus:ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
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
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <p class="mt-1 text-xs text-gray-400">Set a password to restrict access. Leave empty for no password.</p>
        </div>

        
        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
            <a href="<?php echo e(route('pastes.index')); ?>" class="btn btn-secondary">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/workplace/8c6e71eb-7966-45a0-92f9-345b219e3a2e/resources/views/pastes/create.blade.php ENDPATH**/ ?>