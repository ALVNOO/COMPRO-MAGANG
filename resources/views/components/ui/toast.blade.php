{{--
    Toast Notification Component

    Usage:
    1. Include this component once in your layout
    2. Trigger toasts via Alpine.js events or JavaScript

    Example Alpine.js:
    $dispatch('toast', { type: 'success', message: 'Data berhasil disimpan!' })

    Example JavaScript:
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { type: 'success', message: 'Data berhasil disimpan!' }
    }))
--}}

<div
    x-data="toastNotification()"
    x-on:toast.window="addToast($event.detail)"
    class="fixed top-4 right-4 z-[800] flex flex-col gap-3 pointer-events-none"
    style="max-width: 400px;"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="toast-notification pointer-events-auto"
            :class="getToastClass(toast.type)"
            role="alert"
        >
            <div class="toast-icon">
                <template x-if="toast.type === 'success'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </template>
            </div>
            <div class="toast-content">
                <p class="toast-title" x-text="toast.title" x-show="toast.title"></p>
                <p class="toast-message" x-text="toast.message"></p>
            </div>
            <button
                type="button"
                class="toast-close"
                @click="removeToast(toast.id)"
            >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
            {{-- Progress bar --}}
            <div class="toast-progress" x-show="toast.duration > 0">
                <div
                    class="toast-progress-bar"
                    :style="{ animationDuration: toast.duration + 'ms' }"
                ></div>
            </div>
        </div>
    </template>
</div>

<style>
    .toast-notification {
        display: flex;
        align-items: flex-start;
        gap: var(--space-3);
        padding: var(--space-4);
        background: var(--color-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }

    .toast-notification.toast-success {
        border-left-color: var(--color-success);
    }
    .toast-notification.toast-success .toast-icon {
        color: var(--color-success);
    }
    .toast-notification.toast-success .toast-progress-bar {
        background: var(--color-success);
    }

    .toast-notification.toast-error {
        border-left-color: var(--color-danger);
    }
    .toast-notification.toast-error .toast-icon {
        color: var(--color-danger);
    }
    .toast-notification.toast-error .toast-progress-bar {
        background: var(--color-danger);
    }

    .toast-notification.toast-warning {
        border-left-color: var(--color-warning);
    }
    .toast-notification.toast-warning .toast-icon {
        color: var(--color-warning);
    }
    .toast-notification.toast-warning .toast-progress-bar {
        background: var(--color-warning);
    }

    .toast-notification.toast-info {
        border-left-color: var(--color-info);
    }
    .toast-notification.toast-info .toast-icon {
        color: var(--color-info);
    }
    .toast-notification.toast-info .toast-progress-bar {
        background: var(--color-info);
    }

    .toast-icon {
        flex-shrink: 0;
        margin-top: 2px;
    }

    .toast-content {
        flex: 1;
        min-width: 0;
    }

    .toast-title {
        font-weight: var(--font-semibold);
        font-size: var(--text-sm);
        color: var(--color-gray-900);
        margin-bottom: var(--space-1);
    }

    .toast-message {
        font-size: var(--text-sm);
        color: var(--color-gray-600);
        margin: 0;
        word-break: break-word;
    }

    .toast-close {
        flex-shrink: 0;
        padding: var(--space-1);
        color: var(--color-gray-400);
        background: transparent;
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .toast-close:hover {
        color: var(--color-gray-600);
        background: var(--color-gray-100);
    }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--color-gray-200);
    }

    .toast-progress-bar {
        height: 100%;
        width: 100%;
        animation: toast-progress linear forwards;
        transform-origin: left;
    }

    @keyframes toast-progress {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }
</style>

<script>
    function toastNotification() {
        return {
            toasts: [],
            toastId: 0,

            addToast(options) {
                const id = ++this.toastId;
                const toast = {
                    id,
                    type: options.type || 'info',
                    title: options.title || null,
                    message: options.message || '',
                    duration: options.duration !== undefined ? options.duration : 5000,
                    visible: true
                };

                this.toasts.push(toast);

                if (toast.duration > 0) {
                    setTimeout(() => {
                        this.removeToast(id);
                    }, toast.duration);
                }
            },

            removeToast(id) {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index > -1) {
                    this.toasts[index].visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }
            },

            getToastClass(type) {
                const classes = {
                    success: 'toast-success',
                    error: 'toast-error',
                    warning: 'toast-warning',
                    info: 'toast-info'
                };
                return classes[type] || classes.info;
            }
        };
    }

    // Global helper function
    window.showToast = function(type, message, options = {}) {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: {
                type,
                message,
                title: options.title || null,
                duration: options.duration !== undefined ? options.duration : 5000
            }
        }));
    };

    // Shorthand helpers
    window.toast = {
        success: (message, options = {}) => showToast('success', message, options),
        error: (message, options = {}) => showToast('error', message, options),
        warning: (message, options = {}) => showToast('warning', message, options),
        info: (message, options = {}) => showToast('info', message, options)
    };
</script>
