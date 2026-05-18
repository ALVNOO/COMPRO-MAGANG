@props([
    'align' => 'right',  // left | right
    'width' => '200px',
])

@once
<style>
.dropdown-menu {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 10px 15px rgba(0,0,0,.1), 0 4px 6px rgba(0,0,0,.05);
    border: 1px solid #E5E7EB;
    padding: 0.5rem 0;
    min-width: 200px;
    position: absolute;
    top: calc(100% + 6px);
    z-index: 200;
}
.dropdown-menu.align-right  { right: 0; }
.dropdown-menu.align-left   { left: 0; }

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #4B5563;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
}
.dropdown-item:hover { background: #F9FAFB; color: #EE2E24; }
.dropdown-item i { width: 16px; color: #9CA3AF; font-size: 0.875rem; flex-shrink: 0; }
.dropdown-item:hover i { color: #EE2E24; }
.dropdown-item.danger { color: #DC2626; }
.dropdown-item.danger:hover { background: #FEE2E2; color: #B91C1C; }
.dropdown-item.danger i, .dropdown-item.danger:hover i { color: currentColor; }
.dropdown-divider { height: 1px; background: #E5E7EB; margin: 0.5rem 0; }
</style>
@endonce

<div x-data="{ open: false }" style="position:relative;" @click.away="open = false">
    {{-- Trigger --}}
    <div @click="open = !open" style="cursor:pointer;">
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div class="dropdown-menu align-{{ $align }}"
         style="min-width:{{ $width }}; display:none;"
         x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         @click="open = false">
        {{ $slot }}
    </div>
</div>
