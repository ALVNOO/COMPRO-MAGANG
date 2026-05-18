@props([
    'title'       => '',
    'description' => null,
    'icon'        => null,
    'role'        => 'peserta',
    'stats'       => [],
])

@php
    $roleClass = match($role) {
        'admin'      => 'ctx-admin',
        'pembimbing' => 'ctx-mentor',
        default      => 'ctx-peserta',
    };
@endphp

@once
<style>
.page-ctx {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: #ffffff;
    border-radius: 1rem;
    border: 1px solid #E5E7EB;
    border-left: 4px solid transparent;
    box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06);
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.ctx-admin   { border-left-color: #EE2E24; }
.ctx-mentor  { border-left-color: #0891B2; }
.ctx-peserta { border-left-color: #059669; }

.ctx-body { display: flex; align-items: center; gap: 0.75rem; }

.ctx-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    flex-shrink: 0;
}
.ctx-admin   .ctx-icon { background: rgba(238,46,36,.1);  color: #EE2E24; }
.ctx-mentor  .ctx-icon { background: rgba(8,145,178,.1);  color: #0891B2; }
.ctx-peserta .ctx-icon { background: #D1FAE5;             color: #059669; }

.ctx-title { font-size: 1.125rem; font-weight: 600; color: #231F20; line-height: 1.3; }
.ctx-desc  { font-size: 0.875rem; color: #9CA3AF; margin-top: 2px; }

.ctx-right  { display: flex; align-items: center; gap: 1rem; }
.ctx-stats  { display: flex; gap: 1rem; }
.ctx-stat   { text-align: center; }
.ctx-stat-val   { font-size: 1.125rem; font-weight: 700; color: #231F20; line-height: 1.2; }
.ctx-stat-label { font-size: 0.75rem; color: #9CA3AF; font-weight: 500; }

.ctx-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all .15s;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: #ffffff;
}
.ctx-cta:hover { filter: brightness(1.08); transform: translateY(-1px); color: #ffffff; }
.ctx-mentor  .ctx-cta { background: linear-gradient(135deg, #0891B2 0%, #0E7490 100%); }
.ctx-peserta .ctx-cta { background: linear-gradient(135deg, #059669 0%, #047857 100%); }

.ctx-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid #D1D5DB;
    cursor: pointer;
    background: #ffffff;
    color: #4B5563;
    transition: all .15s;
}
.ctx-btn-secondary:hover { background: #F9FAFB; color: #231F20; }

@media (max-width: 768px) {
    .page-ctx  { flex-direction: column; align-items: flex-start; }
    .ctx-stats { display: none; }
}
</style>
@endonce

<div {{ $attributes->merge(['class' => 'page-ctx ' . $roleClass]) }}>
    <div class="ctx-body">
        @if($icon)
            <div class="ctx-icon">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        <div>
            <div class="ctx-title">{{ $title }}</div>
            @if($description)
                <div class="ctx-desc">{{ $description }}</div>
            @endif
        </div>
    </div>

    <div class="ctx-right">
        @if(count($stats))
            <div class="ctx-stats">
                @foreach($stats as $stat)
                    <div class="ctx-stat">
                        <div class="ctx-stat-val">{{ $stat['val'] }}</div>
                        <div class="ctx-stat-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif
        {{ $slot }}
    </div>
</div>
