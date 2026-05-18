@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'required' => false,
    'hint' => null,
    'error' => null,
    'prepend' => null,
    'append' => null
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'form-label-required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <div class="{{ ($prepend || $append) ? 'flex items-center' : '' }}">
        @if($prepend)
            <span class="form-prepend px-4 py-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg text-gray-500">
                {{ $prepend }}
            </span>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'form-input' .
                    ($error ? ' is-invalid' : '') .
                    ($prepend ? ' rounded-l-none' : '') .
                    ($append ? ' rounded-r-none' : '')
            ]) }}
            @if($required) required @endif
        >

        @if($append)
            <span class="form-append px-4 py-3 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg text-gray-500">
                {{ $append }}
            </span>
        @endif
    </div>

    @if($hint && !$error)
        <span class="form-hint">{{ $hint }}</span>
    @endif

    @if($error)
        <span class="form-error">{{ $error }}</span>
    @endif

    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
