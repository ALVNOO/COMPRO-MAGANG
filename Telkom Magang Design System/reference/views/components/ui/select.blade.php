@props([
    'name' => '',
    'label' => null,
    'required' => false,
    'hint' => null,
    'error' => null,
    'options' => [],
    'placeholder' => 'Pilih...',
    'selected' => null
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'form-label-required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-select' . ($error ? ' is-invalid' : '')]) }}
        @if($required) required @endif
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach

        {{ $slot }}
    </select>

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
