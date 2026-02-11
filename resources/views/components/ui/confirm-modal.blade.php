{{--
    Confirmation Modal Component

    Usage:
    <x-ui.confirm-modal
        id="delete-confirm"
        title="Hapus Data?"
        message="Apakah Anda yakin ingin menghapus data ini?"
        type="danger"
        confirmText="Ya, Hapus"
        cancelText="Batal"
    />

    Trigger via Alpine.js:
    <button @click="$dispatch('open-confirm', {
        id: 'delete-confirm',
        onConfirm: () => deleteItem(id)
    })">Delete</button>
--}}

@props([
    'id' => 'confirm-modal',
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin ingin melanjutkan?',
    'type' => 'warning',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'icon' => null
])

@php
    $types = [
        'warning' => [
            'color' => 'warning',
            'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
            'btnClass' => 'btn-primary'
        ],
        'danger' => [
            'color' => 'danger',
            'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>',
            'btnClass' => 'btn-danger'
        ],
        'info' => [
            'color' => 'info',
            'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'btnClass' => 'btn-primary'
        ],
        'success' => [
            'color' => 'success',
            'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'btnClass' => 'btn-success'
        ]
    ];

    $config = $types[$type] ?? $types['warning'];
@endphp

<div
    x-data="confirmModal('{{ $id }}')"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[600] overflow-y-auto"
    aria-labelledby="{{ $id }}-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        class="fixed inset-0 bg-black/50 transition-opacity"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="close()"
    ></div>

    {{-- Modal --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="confirm-modal"
            @click.stop
        >
            <div class="confirm-modal-content">
                {{-- Icon --}}
                <div class="confirm-modal-icon confirm-modal-icon-{{ $config['color'] }}">
                    @if($icon)
                        <i class="{{ $icon }}"></i>
                    @else
                        {!! $config['icon'] !!}
                    @endif
                </div>

                {{-- Title --}}
                <h3 class="confirm-modal-title" id="{{ $id }}-title">
                    {{ $title }}
                </h3>

                {{-- Message --}}
                <p class="confirm-modal-message" x-text="message || '{{ $message }}'">
                    {{ $message }}
                </p>

                {{-- Custom slot content --}}
                {{ $slot }}
            </div>

            {{-- Actions --}}
            <div class="confirm-modal-actions">
                <button
                    type="button"
                    class="btn btn-secondary"
                    @click="close()"
                    :disabled="isLoading"
                >
                    {{ $cancelText }}
                </button>
                <button
                    type="button"
                    class="btn {{ $config['btnClass'] }}"
                    @click="confirm()"
                    :disabled="isLoading"
                    :class="{ 'is-loading': isLoading }"
                >
                    <span x-show="!isLoading">{{ $confirmText }}</span>
                    <span x-show="isLoading" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@once
<style>
    .confirm-modal {
        width: 100%;
        max-width: 400px;
        background: var(--color-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
    }

    .confirm-modal-content {
        padding: var(--space-6);
        text-align: center;
    }

    .confirm-modal-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto var(--space-4);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .confirm-modal-icon-warning {
        background: var(--color-warning-light);
        color: var(--color-warning);
    }

    .confirm-modal-icon-danger {
        background: var(--color-danger-light);
        color: var(--color-danger);
    }

    .confirm-modal-icon-info {
        background: var(--color-info-light);
        color: var(--color-info);
    }

    .confirm-modal-icon-success {
        background: var(--color-success-light);
        color: var(--color-success);
    }

    .confirm-modal-title {
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
        color: var(--color-gray-900);
        margin: 0 0 var(--space-2);
    }

    .confirm-modal-message {
        font-size: var(--text-sm);
        color: var(--color-gray-600);
        margin: 0;
        line-height: var(--leading-relaxed);
    }

    .confirm-modal-actions {
        display: flex;
        gap: var(--space-3);
        padding: var(--space-4) var(--space-6);
        background: var(--color-gray-50);
        border-top: 1px solid var(--color-gray-200);
    }

    .confirm-modal-actions .btn {
        flex: 1;
    }
</style>

<script>
    function confirmModal(modalId) {
        return {
            isOpen: false,
            isLoading: false,
            message: null,
            onConfirm: null,
            onCancel: null,

            init() {
                window.addEventListener('open-confirm', (e) => {
                    if (e.detail.id === modalId) {
                        this.message = e.detail.message || null;
                        this.onConfirm = e.detail.onConfirm || null;
                        this.onCancel = e.detail.onCancel || null;
                        this.isOpen = true;
                    }
                });

                window.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isOpen) {
                        this.close();
                    }
                });
            },

            async confirm() {
                if (this.onConfirm) {
                    this.isLoading = true;
                    try {
                        await this.onConfirm();
                    } catch (error) {
                        console.error('Confirm action failed:', error);
                    } finally {
                        this.isLoading = false;
                    }
                }
                this.close();
            },

            close() {
                if (this.onCancel) {
                    this.onCancel();
                }
                this.isOpen = false;
                this.message = null;
                this.onConfirm = null;
                this.onCancel = null;
            }
        };
    }

    // Global helper function
    window.confirm = function(options) {
        return new Promise((resolve) => {
            window.dispatchEvent(new CustomEvent('open-confirm', {
                detail: {
                    id: options.id || 'confirm-modal',
                    message: options.message,
                    onConfirm: () => resolve(true),
                    onCancel: () => resolve(false)
                }
            }));
        });
    };
</script>
@endonce
