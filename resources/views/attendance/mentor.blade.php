@extends('layouts.mentor-dashboard')

@section('title', 'Absensi Peserta Magang - Mentor Dashboard')

@push('styles')
<style>
    /* Reset container to prevent glitches */
    .attendance-container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        max-width: 100% !important;
    }

    /* Compact table cells */
    .attendance-table td,
    .attendance-table th {
        padding: 0.75rem 0.5rem !important;
        white-space: nowrap;
        vertical-align: middle;
    }

    .attendance-table td:first-child {
        white-space: normal;
        min-width: 160px;
        max-width: 200px;
    }

    /* Smaller history boxes */
    .history-box {
        width: 26px;
        height: 26px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        flex-shrink: 0;
    }

    .history-box i {
        font-size: 0.65rem;
    }

    /* Compact badges */
    .status-badge {
        padding: 0.3rem 0.6rem !important;
        border-radius: 6px !important;
        font-weight: 600;
        font-size: 0.75rem !important;
        white-space: nowrap;
        display: inline-block;
    }

    /* Compact participant info */
    .participant-avatar-sm {
        width:38px;
        height:38px;
        font-size: 1rem;
    }

    /* Ensure cards don't overflow */
    .attendance-card {
        margin-bottom: 1rem;
    }

    /* Fix row margins */
    .attendance-row {
        margin-left: 0;
        margin-right: 0;
    }

    /* Make table responsive without overflow */
    .attendance-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3">
    <!-- Page Header -->
    <div class="page-header" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); padding: 1.25rem 1.5rem; border-radius: 12px; color: white; margin-bottom: 1rem;">
        <h1 style="font-size: 1.4rem; font-weight: 600; margin-bottom: 0.25rem;">
            <i class="fas fa-calendar-check me-2"></i>
            Absensi Peserta Magang
        </h1>
        <p style="opacity: 0.9; margin-bottom: 0; font-size: 0.85rem;">
            Pantau kehadiran peserta magang Anda
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($participants->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada peserta magang yang diterima di divisi Anda.
        </div>
    @else
        <!-- Date Filter Section -->
        <div class="card attendance-card" style="border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 1.5rem;">
            <div class="card-body" style="padding: 1rem;">
                <form method="GET" action="{{ route('mentor.absensi') }}" id="attendanceFilterForm">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4 col-sm-6">
                            <label class="form-label mb-2" style="font-weight: 600; color: #000; font-size: 0.875rem;">
                                <i class="fas fa-calendar me-1 text-danger"></i>Filter Tanggal
                            </label>
                            <input type="date" name="date" id="filterDate" class="form-control" value="{{ $filterDate ?? today()->toDateString() }}" max="{{ today()->toDateString() }}" style="border-radius: 8px; border: 1.5px solid #EE2E24; font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <button type="submit" id="applyFilterBtn" class="btn w-100" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 8px; font-weight: 600; padding: 0.5rem 0.75rem; font-size: 0.9rem;">
                                <i class="fas fa-filter me-1"></i>Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            @php
                $totalParticipants = $participants->count();
                $presentCount = 0;
                $lateCount = 0;
                $absentCount = 0;

                foreach($participants as $participant) {
                    if($participant['attendance']) {
                        if($participant['attendance']->status === 'Hadir') $presentCount++;
                        elseif($participant['attendance']->status === 'Terlambat') $lateCount++;
                        elseif($participant['attendance']->status === 'Absen') $absentCount++;
                    }
                }
            @endphp

            <!-- Total Participants -->
            <div class="col-md-3 col-6 mb-2">
                <div class="card h-100" style="border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <div class="card-body text-center" style="padding: 0.65rem;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.4rem; color: white;">
                            <i class="fas fa-users" style="font-size: 1.15rem;"></i>
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #000; margin-bottom: 0.1rem; line-height: 1;">{{ $totalParticipants }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0; font-size: 0.8rem;">Total Peserta</p>
                    </div>
                </div>
            </div>

            <!-- Present -->
            <div class="col-md-3 col-6 mb-2">
                <div class="card h-100" style="border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <div class="card-body text-center" style="padding: 0.65rem;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #198754 0%, #20c997 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.4rem; color: white;">
                            <i class="fas fa-user-check" style="font-size: 1.15rem;"></i>
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #198754; margin-bottom: 0.1rem; line-height: 1;">{{ $presentCount }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0; font-size: 0.8rem;">Hadir</p>
                    </div>
                </div>
            </div>

            <!-- Late -->
            <div class="col-md-3 col-6 mb-2">
                <div class="card h-100" style="border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <div class="card-body text-center" style="padding: 0.65rem;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.4rem; color: white;">
                            <i class="fas fa-clock" style="font-size: 1.15rem;"></i>
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #ffc107; margin-bottom: 0.1rem; line-height: 1;">{{ $lateCount }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0; font-size: 0.8rem;">Terlambat</p>
                    </div>
                </div>
            </div>

            <!-- Absent -->
            <div class="col-md-3 col-6 mb-2">
                <div class="card h-100" style="border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <div class="card-body text-center" style="padding: 0.65rem;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.4rem; color: white;">
                            <i class="fas fa-user-times" style="font-size: 1.15rem;"></i>
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #dc3545; margin-bottom: 0.1rem; line-height: 1;">{{ $absentCount }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0; font-size: 0.8rem;">Absen</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card attendance-card" style="border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div class="card-body p-0">
                <div class="attendance-table-wrapper">
                    <table class="table table-hover attendance-table mb-0" style="min-width: 700px;">
                        <thead style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white;">
                            <tr>
                                <th style="border: none;">Peserta</th>
                                <th style="border: none; text-align: center;">Status</th>
                                <th style="border: none; text-align: center;">Waktu</th>
                                <th style="border: none; text-align: center;">Riwayat 7 Hari</th>
                                <th style="border: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $participant)
                                @php
                                    $todayAttendance = $participant['attendance'];
                                @endphp
                                <tr>
                                    <!-- Participant Info -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="participant-avatar-sm" style="border-radius: 50%; background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0;">
                                                {{ strtoupper(substr($participant['user']->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 600; color: #000; margin-bottom: 0.15rem; font-size: 0.9rem;">{{ $participant['user']->name ?? '-' }}</div>
                                                <div style="font-size: 0.75rem; color: #AAA5A6;">{{ $participant['user']->nim ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status Today -->
                                    <td style="text-align: center;">
                                        @if($todayAttendance)
                                            @if($todayAttendance->status === 'Hadir')
                                                <span class="badge status-badge" style="background: #198754; color: white;">
                                                    <i class="fas fa-check-circle me-1"></i>Hadir
                                                </span>
                                            @elseif($todayAttendance->status === 'Terlambat')
                                                <span class="badge status-badge" style="background: #ffc107; color: white;">
                                                    <i class="fas fa-clock me-1"></i>Terlambat
                                                </span>
                                            @else
                                                <span class="badge status-badge" style="background: #dc3545; color: white;">
                                                    <i class="fas fa-times-circle me-1"></i>Absen
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge status-badge" style="background: #AAA5A6; color: white;">
                                                <i class="fas fa-minus-circle me-1"></i>Belum
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Check-in Time -->
                                    <td style="text-align: center;">
                                        <span style="font-weight: 600; color: #000; font-size: 0.9rem;">
                                            {{ $todayAttendance ? \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') : '-' }}
                                        </span>
                                    </td>

                                    <!-- 7-Day History -->
                                    <td style="text-align: center;">
                                        <div class="d-flex justify-content-center gap-1" style="flex-wrap: nowrap;">
                                            @foreach($participant['workingDays'] as $day)
                                                @php
                                                    $dayAttendance = $participant['last7Days']->where('date', $day)->first();
                                                    $bgColor = '#e9ecef'; // Default grey
                                                    $icon = 'minus';
                                                    $tooltip = \Carbon\Carbon::parse($day)->format('d M');

                                                    if($dayAttendance) {
                                                        if($dayAttendance->status === 'Hadir') {
                                                            $bgColor = '#198754';
                                                            $icon = 'check';
                                                            $tooltip .= ' - Hadir';
                                                        } elseif($dayAttendance->status === 'Terlambat') {
                                                            $bgColor = '#ffc107';
                                                            $icon = 'clock';
                                                            $tooltip .= ' - Terlambat';
                                                        } else {
                                                            $bgColor = '#dc3545';
                                                            $icon = 'times';
                                                            $tooltip .= ' - Absen';
                                                        }
                                                    } else {
                                                        $tooltip .= ' - Tidak ada data';
                                                    }
                                                @endphp
                                                <div title="{{ $tooltip }}" class="history-box" style="background: {{ $bgColor }};" data-bs-toggle="tooltip">
                                                    <i class="fas fa-{{ $icon }}"></i>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td style="text-align: center;">
                                        @if($todayAttendance && $todayAttendance->photo_path)
                                            <button onclick="showPhoto('{{ $participant['user']->name }}', '{{ asset('storage/' . $todayAttendance->photo_path) }}', '{{ $todayAttendance->status }}', '{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}', '{{ $todayAttendance->keterangan ?? '' }}')" class="btn btn-sm" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 6px; padding: 0.35rem 0.75rem; font-weight: 600; font-size: 0.8rem; white-space: nowrap;">
                                                <i class="fas fa-image me-1"></i>Foto
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled style="border-radius: 6px; padding: 0.35rem 0.75rem; font-size: 0.8rem; white-space: nowrap;">
                                                <i class="fas fa-image me-1"></i>-
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 16px 16px 0 0; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-camera me-2"></i>
                    Foto Absensi - <span id="modalName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" aria-label="Close" id="closePhotoModalBtn" onclick="window.closePhotoModal && window.closePhotoModal()"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <img id="modalPhoto" src="" alt="Foto Absensi" class="img-fluid" style="border-radius: 12px; width: 100%; height: auto;">
                    </div>
                    <div class="col-md-5">
                        <h6 style="font-weight: 600; color: #000; margin-bottom: 1rem;">Detail Absensi</h6>
                        <div class="mb-3">
                            <label style="color: #AAA5A6; font-size: 0.875rem; display: block; margin-bottom: 0.25rem;">Status</label>
                            <div id="modalStatus"></div>
                        </div>
                        <div class="mb-3">
                            <label style="color: #AAA5A6; font-size: 0.875rem; display: block; margin-bottom: 0.25rem;">Waktu Check-in</label>
                            <div style="font-weight: 600; color: #000;" id="modalTime"></div>
                        </div>
                        <div class="mb-3">
                            <label style="color: #AAA5A6; font-size: 0.875rem; display: block; margin-bottom: 0.25rem;">Keterangan</label>
                            <div style="color: #000;" id="modalReason"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: none; padding: 1rem 2rem;">
                <button type="button" class="btn btn-secondary" id="closePhotoModalFooterBtn" onclick="window.closePhotoModal && window.closePhotoModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Function to close modal properly
function closePhotoModal() {
    const modalElement = document.getElementById('photoModal');
    if (!modalElement) return;
    
    // Check for Bootstrap in multiple ways
    let bootstrapObj = null;
    if (typeof window !== 'undefined' && window.bootstrap) {
        bootstrapObj = window.bootstrap;
    } else if (typeof bootstrap !== 'undefined') {
        bootstrapObj = bootstrap;
    }
    
    if (bootstrapObj && bootstrapObj.Modal) {
        try {
            const modal = bootstrapObj.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
                return;
            }
        } catch (e) {
            console.log('Error getting modal instance:', e);
        }
    }
    
    // Fallback: manually hide modal (always works)
    modalElement.classList.remove('show');
    modalElement.style.display = 'none';
    modalElement.setAttribute('aria-hidden', 'true');
    modalElement.removeAttribute('aria-modal');
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    
    // Remove backdrop
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.classList.remove('show');
        setTimeout(function() {
            backdrop.remove();
        }, 150);
    }
}

// Make it available globally immediately
window.closePhotoModal = closePhotoModal;

// Ensure filter form submits correctly - prevent loading animation from blocking GET form
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('attendanceFilterForm');
    const applyBtn = document.getElementById('applyFilterBtn');
    
    if (filterForm && applyBtn) {
        // Override any loading animation for this specific button
        applyBtn.addEventListener('click', function(e) {
            // For GET forms, don't show loading animation and allow immediate submit
            e.stopPropagation(); // Prevent other handlers
            // Form will submit normally
        }, true); // Use capture phase to run before other handlers
        
        // Ensure form submits
        filterForm.addEventListener('submit', function(e) {
            // Allow GET forms to submit normally
            return true;
        });
    }
});

// Use event delegation for close buttons (works even if buttons are added dynamically)
document.addEventListener('click', function(e) {
    // Check if clicked element is close button or inside close button
    if (e.target.id === 'closePhotoModalBtn' || e.target.closest('#closePhotoModalBtn')) {
        e.preventDefault();
        e.stopPropagation();
        closePhotoModal();
        return false;
    }
    
    // Check if clicked element is footer close button
    if (e.target.id === 'closePhotoModalFooterBtn' || e.target.closest('#closePhotoModalFooterBtn')) {
        e.preventDefault();
        e.stopPropagation();
        closePhotoModal();
        return false;
    }
    
    // Close modal when clicking on backdrop
    const modalElement = document.getElementById('photoModal');
    if (modalElement && e.target === modalElement && modalElement.classList.contains('show')) {
        closePhotoModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    const modalElement = document.getElementById('photoModal');
    if (e.key === 'Escape' && modalElement && modalElement.classList.contains('show')) {
        closePhotoModal();
    }
});

// Define showPhoto function immediately so it's available for onclick handlers
// This will be available as soon as the script loads
window.showPhoto = function(name, photo, status, time, reason) {
    const modalNameEl = document.getElementById('modalName');
    const modalPhotoEl = document.getElementById('modalPhoto');
    const modalTimeEl = document.getElementById('modalTime');
    const modalReasonEl = document.getElementById('modalReason');
    const modalStatusEl = document.getElementById('modalStatus');
    const modalElement = document.getElementById('photoModal');
    
    if (!modalElement || !modalNameEl || !modalPhotoEl || !modalTimeEl || !modalReasonEl || !modalStatusEl) {
        console.error('Modal elements not found');
        return;
    }
    
    modalNameEl.textContent = name;
    modalPhotoEl.src = photo;
    modalTimeEl.textContent = time;
    modalReasonEl.textContent = reason || '-';

    // Set status badge
    let statusBadge = '';
    if(status === 'Hadir') {
        statusBadge = '<span class="badge" style="background: #198754; color: white; padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-check-circle me-1"></i>Hadir</span>';
    } else if(status === 'Terlambat') {
        statusBadge = '<span class="badge" style="background: #ffc107; color: white; padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-clock me-1"></i>Terlambat</span>';
    } else {
        statusBadge = '<span class="badge" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-times-circle me-1"></i>Absen</span>';
    }
    modalStatusEl.innerHTML = statusBadge;

    // Show modal using Bootstrap 5 - wait for Bootstrap to be available
    function showModal() {
        // Check for Bootstrap in multiple ways
        let bootstrapObj = null;
        if (typeof window !== 'undefined' && window.bootstrap) {
            bootstrapObj = window.bootstrap;
        } else if (typeof bootstrap !== 'undefined') {
            bootstrapObj = bootstrap;
        }
        
        if (bootstrapObj && bootstrapObj.Modal) {
                try {
                    const modal = bootstrapObj.Modal.getOrCreateInstance(modalElement);
                    modal.show();
                    
                    // Ensure closePhotoModal is available
                    window.closePhotoModal = closePhotoModal;
                    
                    // Add event listener for when modal is hidden to clean up
                    modalElement.addEventListener('hidden.bs.modal', function() {
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    }, { once: true });
            } catch (e) {
                console.error('Error showing modal:', e);
                // Fallback: try to create new modal instance
                try {
                    const modal = new bootstrapObj.Modal(modalElement);
                    modal.show();
                    
                    // Add event listener for when modal is hidden to clean up
                    modalElement.addEventListener('hidden.bs.modal', function() {
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    }, { once: true });
                } catch (e2) {
                    console.error('Error creating modal:', e2);
                    // Last resort: show modal manually
                    modalElement.classList.add('show');
                    modalElement.style.display = 'block';
                    document.body.classList.add('modal-open');
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    backdrop.setAttribute('id', 'photoModalBackdrop');
                    document.body.appendChild(backdrop);
                    
                    // Add click handler to backdrop
                    backdrop.addEventListener('click', function() {
                        window.closePhotoModal();
                    });
                }
            }
        } else {
            // Retry after a short delay if Bootstrap is not yet loaded
            setTimeout(showModal, 100);
        }
    }
    showModal();
};

// Initialize tooltips when DOM and Bootstrap are ready
(function() {
    function initTooltips() {
        let bootstrapObj = null;
        if (typeof window !== 'undefined' && window.bootstrap) {
            bootstrapObj = window.bootstrap;
        } else if (typeof bootstrap !== 'undefined') {
            bootstrapObj = bootstrap;
        }
        
        if (bootstrapObj && bootstrapObj.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrapObj.Tooltip(tooltipTriggerEl);
            });
        } else {
            setTimeout(initTooltips, 100);
        }
    }
    
    // Wait for both DOM and window load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('load', initTooltips);
        });
    } else {
        window.addEventListener('load', initTooltips);
    }
})();

</script>
@endsection
