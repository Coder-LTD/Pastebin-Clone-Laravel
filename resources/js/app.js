import './bootstrap';
import hljs from 'highlight.js';

// Initialize highlight.js on all code blocks
hljs.highlightAll();

// Copy-to-clipboard functionality
document.addEventListener('DOMContentLoaded', () => {
    const copyButtons = document.querySelectorAll('[data-copy]');

    copyButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            const targetSelector = button.getAttribute('data-copy');
            const target = document.querySelector(targetSelector);

            if (!target) return;

            const text = target.textContent || target.innerText;

            try {
                await navigator.clipboard.writeText(text);

                // Show "Copied!" feedback
                const originalHTML = button.innerHTML;
                button.classList.add('copied');
                button.innerHTML = `
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Copied!
                `;

                setTimeout(() => {
                    button.classList.remove('copied');
                    button.innerHTML = originalHTML;
                }, 2000);
            } catch (err) {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    button.classList.add('copied');
                    const originalText = button.textContent;
                    button.textContent = 'Copied!';
                    setTimeout(() => {
                        button.classList.remove('copied');
                        button.textContent = originalText;
                    }, 2000);
                } catch (e) {
                    console.error('Copy failed:', e);
                }
                document.body.removeChild(textarea);
            }
        });
    });

    // Password field toggle show/hide
    const passwordToggles = document.querySelectorAll('[data-password-toggle]');

    passwordToggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.getAttribute('data-password-toggle');
            const input = document.querySelector(targetId);

            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            // Toggle icon
            const icon = toggle.querySelector('svg');
            if (icon) {
                if (isPassword) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 01-4.243 4.243M6.343 6.343L17.657 17.657" />';
                } else {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                }
            }

            // Toggle text
            const textEl = toggle.querySelector('span');
            if (textEl) {
                textEl.textContent = isPassword ? 'Hide' : 'Show';
            }
        });
    });

    // Auto-dismiss flash messages
    const flashMessages = document.querySelectorAll('[data-flash]');
    flashMessages.forEach((msg) => {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.3s ease-out';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 300);
        }, 5000);
    });
});
