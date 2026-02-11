{{--
    STATUS PAGE - MODULAR VERSION
    =============================
    Refactored from monolithic 2600+ line file into modular partials

    Partials used:
    - status-styles.blade.php      : All CSS styles
    - status-hero.blade.php        : Hero section with user info
    - status-stepper.blade.php     : Progress stepper component
    - status-biodata-card.blade.php    : Applicant biodata
    - status-field-card.blade.php      : Field of interest
    - status-pending-card.blade.php    : Pending/rejected status
    - status-placement-card.blade.php  : Accepted placement details
    - status-timeline.blade.php        : Application timeline
    - status-contact-sidebar.blade.php : Contact information
    - status-empty-state.blade.php     : No application state
    - status-scripts.blade.php         : JavaScript animations
--}}

@extends('layouts.dashboard')

@section('title', 'Status Pengajuan - PT Telkom Indonesia')

@push('styles')
    @include('dashboard.partials.status-styles')
@endpush

@section('content')
<div class="status-page">
    {{-- Floating Gradient Orbs --}}
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>

    <div class="content-wrapper">
        @if($application)
            @php
                // Status flags
                $isAccepted = in_array($application->status, ['accepted', 'finished']);
                $isPending = $application->status == 'pending';
                $isRejected = $application->status == 'rejected';
                $isFinished = $application->status == 'finished';

                // Determine step progress
                $currentStep = 1;
                if($isPending) $currentStep = 2;
                if($isAccepted) $currentStep = 3;
                if($isFinished) $currentStep = 4;
                if($isRejected) $currentStep = -1;

                $progressPercent = $isRejected ? 25 : (($currentStep / 4) * 100);
            @endphp

            {{-- Hero Section --}}
            @include('dashboard.partials.status-hero', [
                'user' => $user,
                'isPending' => $isPending,
                'isAccepted' => $isAccepted,
                'isRejected' => $isRejected,
                'isFinished' => $isFinished
            ])

            {{-- Progress Stepper --}}
            @include('dashboard.partials.status-stepper', [
                'currentStep' => $currentStep,
                'progressPercent' => $progressPercent,
                'isPending' => $isPending,
                'isAccepted' => $isAccepted,
                'isRejected' => $isRejected,
                'isFinished' => $isFinished
            ])

            {{-- Main Grid --}}
            <div class="main-grid">
                <div class="main-content">
                    @if(!$isAccepted)
                        {{-- Not Accepted: Show biodata, field, and pending status --}}
                        @include('dashboard.partials.status-biodata-card', ['user' => $user])
                        @include('dashboard.partials.status-field-card', ['application' => $application])
                        @include('dashboard.partials.status-pending-card', ['application' => $application])
                    @else
                        {{-- Accepted: Show placement details and timeline --}}
                        @include('dashboard.partials.status-placement-card', ['application' => $application])
                        @include('dashboard.partials.status-timeline', ['application' => $application])
                    @endif
                </div>

                {{-- Sidebar --}}
                <div>
                    @include('dashboard.partials.status-contact-sidebar')
                </div>
            </div>
        @else
            {{-- Empty State --}}
            @include('dashboard.partials.status-empty-state')
        @endif
    </div>
</div>

@push('scripts')
    @include('dashboard.partials.status-scripts')
@endpush
@endsection
