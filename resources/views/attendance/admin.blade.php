@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container-fluid">
    <div class="mx-auto" style="max-width: 1100px;">
        <div class="mb-4">
            <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">
                Daily Attendance
            </h2>
        <p class="text-sm text-[#000000]">Pantau absensi peserta magang</p>
    </div>

        <!-- Filter Section (mirip halaman mentor + filter divisi) -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
            <form id="adminAttendanceFilterForm" method="GET" action="{{ route('admin.attendance') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="division_id" class="form-label">Filter Divisi</label>
                <select class="form-select" id="division_id" name="division_id">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                            {{ $division->division_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="date" class="form-label">Filter Tanggal</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $filterDate }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="{{ route('admin.attendance') }}" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
        </div>

        <!-- Attendance Table (struktur dan styling mengikuti halaman mentor) -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Data Absensi - {{ \Carbon\Carbon::parse($filterDate)->format('d M Y') }}</h5>
            </div>
            <div class="card-body">
            @if($participants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;" class="text-center">#</th>
                            <th style="width: 20%;">Nama Peserta Magang</th>
                            <th style="width: 12%;" class="text-center">Status</th>
                            <th style="width: 30%;" class="text-center">Status 7 Hari Terakhir</th>
                            <th style="width: 15%;" class="text-center">Log</th>
                            <th style="width: 18%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $index => $participant)
                        <tr>
                            <td class="align-middle text-center">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <strong>{{ $participant['user']->name }}</strong><br>
                                <small class="text-muted">{{ $participant['user']->email }}</small><br>
                                @if($participant['application']->divisionAdmin)
                                    <small class="text-muted">{{ $participant['application']->divisionAdmin->division_name }}</small>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($participant['attendance'])
                                    @if($participant['attendance']->status == 'Hadir')
                                        <button class="btn btn-sm btn-success" disabled>✓ PRESENT</button>
                                    @elseif($participant['attendance']->status == 'Absen')
                                        <button class="btn btn-sm btn-warning" disabled>✗ ABSENT</button>
                                    @elseif($participant['attendance']->status == 'Terlambat')
                                        <button class="btn btn-sm btn-warning" disabled>LATE</button>
                                    @endif
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>-</button>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if(isset($participant['workingDays']))
                                        @foreach($participant['workingDays'] as $workDate)
                                            @php
                                                $checkDate = \Carbon\Carbon::parse($workDate);
                                                $dayAttendance = $participant['last7Days']->firstWhere('date', $workDate);
                                            @endphp
                                            <div class="text-center" style="min-width: 30px;">
                                                <small class="d-block text-muted">{{ $checkDate->format('d') }}</small>
                                                @if($dayAttendance)
                                                    @if($dayAttendance->status == 'Hadir')
                                                        <span class="badge bg-success">✓</span>
                                                    @elseif($dayAttendance->status == 'Absen')
                                                        <span class="badge bg-warning">✗</span>
                                                    @elseif($dayAttendance->status == 'Terlambat')
                                                        <span class="badge bg-warning">L</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        @php
                                            $workingDays = collect();
                                            $currentDate = \Carbon\Carbon::parse($filterDate);
                                            $daysBack = 0;
                                            while ($workingDays->count() < 7) {
                                                $checkDate = $currentDate->copy()->subDays($daysBack);
                                                if ($checkDate->dayOfWeek != \Carbon\Carbon::SATURDAY && $checkDate->dayOfWeek != \Carbon\Carbon::SUNDAY) {
                                                    $workingDays->push($checkDate);
                                                }
                                                $daysBack++;
                                                if ($daysBack > 20) break;
                                            }
                                            $workingDays = $workingDays->reverse()->values();
                                        @endphp
                                        @foreach($workingDays as $checkDate)
                                            @php
                                                $dayAttendance = $participant['last7Days']->firstWhere('date', $checkDate->toDateString());
                                            @endphp
                                            <div class="text-center" style="min-width: 30px;">
                                                <small class="d-block text-muted">{{ $checkDate->format('d') }}</small>
                                                @if($dayAttendance)
                                                    @if($dayAttendance->status == 'Hadir')
                                                        <span class="badge bg-success">✓</span>
                                                    @elseif($dayAttendance->status == 'Absen')
                                                        <span class="badge bg-warning">✗</span>
                                                    @elseif($dayAttendance->status == 'Terlambat')
                                                        <span class="badge bg-warning">L</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                @if($participant['attendance'] && $participant['attendance']->check_in_time)
                                    <small>{{ \Carbon\Carbon::parse($participant['attendance']->check_in_time)->format('H:i:s') }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($participant['attendance'] && $participant['attendance']->photo_path)
                                    <button onclick="showPhoto('{{ $participant['user']->name }}', '{{ asset('storage/' . $participant['attendance']->photo_path) }}', '{{ $participant['attendance']->status }}', '{{ $participant['attendance']->check_in_time ? \Carbon\Carbon::parse($participant['attendance']->check_in_time)->format('H:i') : '-' }}', '{{ $participant['attendance']->keterangan ?? '' }}')" class="btn btn-sm btn-primary" style="border-radius: 8px; padding: 0.5rem 1rem;">
                                        <i class="fas fa-image me-1"></i>Lihat Foto
                                    </button>
                                @else
                                    <span class="badge bg-secondary" style="padding: 0.5rem 1rem; border-radius: 8px;">
                                        <i class="fas fa-image me-1"></i>Tidak ada foto
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada data absensi untuk filter yang dipilih.
            </div>
            @endif
            </div>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #B91C1C 0%, #DC2626 100%); color: white; border-radius: 16px 16px 0 0; border: none;">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const divisionSelect = document.getElementById('division_id');
        const filterForm = document.getElementById('adminAttendanceFilterForm');

        if (divisionSelect && filterForm) {
            divisionSelect.addEventListener('change', function () {
                filterForm.submit();
            });
        }
    });

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
            statusBadge = '<span class="badge bg-success" style="padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-check-circle me-1"></i>Hadir</span>';
        } else if(status === 'Terlambat') {
            statusBadge = '<span class="badge bg-warning" style="padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-clock me-1"></i>Terlambat</span>';
        } else {
            statusBadge = '<span class="badge bg-danger" style="padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-times-circle me-1"></i>Absen</span>';
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

    // Add click event listener to backdrop to close modal
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('photoModal');
        if (modalElement) {
            // Close modal when clicking outside (on backdrop)
            modalElement.addEventListener('click', function(e) {
                if (e.target === modalElement) {
                    window.closePhotoModal();
                }
            });
            
            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modalElement.classList.contains('show')) {
                    window.closePhotoModal();
                }
            });
        }
    });
</script>
@endpush