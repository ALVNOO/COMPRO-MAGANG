@props([
    'id' => 'modal',
    'title' => null,
    'size' => 'md',
    'closeButton' => true
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div
    id="{{ $id }}"
    class="fixed inset-0 z-[500] hidden"
    x-data="{ open: false }"
    x-show="open"
    x-on:open-modal-{{ $id }}.window="open = true"
    x-on:close-modal-{{ $id }}.window="open = false"
    x-on:keydown.escape.window="open = false"
>
    {{-- Backdrop --}}
    <div
        class="fixed inset-0 bg-black/50 transition-opacity"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
    ></div>

    {{-- Modal Content --}}
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="w-full {{ $sizeClass }} bg-white rounded-xl shadow-xl transform transition-all"
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.stop
            >
                {{-- Header --}}
                @if($title || $closeButton)
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        @if($title)
                            <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
                        @endif
                        @if($closeButton)
                            <button
                                type="button"
                                class="btn-ghost btn-icon"
                                @click="open = false"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                @endif

                {{-- Body --}}
                <div class="p-6">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                @if(isset($footer))
                    <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
