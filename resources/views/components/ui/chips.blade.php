@once
<style>
.chips-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}
.chip {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.875rem;
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 500;
    border: 1px solid #E5E7EB;
    background: #ffffff;
    color: #6B7280;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    line-height: 1;
}
.chip:hover {
    border-color: #EE2E24;
    color: #EE2E24;
    background: rgba(238, 46, 36, 0.04);
}
.chip.active {
    border-color: #EE2E24;
    color: #EE2E24;
    background: rgba(238, 46, 36, 0.08);
    font-weight: 600;
}
</style>
@endonce

<div class="chips-bar">
    {{ $slot }}
</div>
