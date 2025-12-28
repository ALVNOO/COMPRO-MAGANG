@extends('layouts.dashboard')

@section('title', 'Absensi - PT Pos Indonesia')

@push('styles')
<style>
    .attendance-card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    .btn-checkin {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        color: white;
        transition: all 0.3s;
    }
    .btn-checkin:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
    }
    .btn-absent {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        color: white;
        transition: all 0.3s;
    }
    .btn-absent:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
    }
    .status-hadir {
        background: #d4edda;
        color: #155724;
    }
    .status-absen {
        background: #f8d7da;
        color: #721c24;
    }
    .status-terlambat {
        background: #fff3cd;
        color: #856404;
    }
    .photo-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 1rem;
    }
    #cameraPreview {
        width: 100%;
        max-width: 500px;
        border-radius: 8px;
        margin: 1rem auto;
        display: block;
        background: #000;
    }
    #capturedPhoto {
        width: 100%;
        max-width: 500px;
        border-radius: 8px;
        margin: 1rem auto;
        display: none;
    }
    .camera-controls {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1rem;
    }
    .btn-capture {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        color: white;
    }
    .btn-retake {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Absensi</h1>
            <p class="text-muted">Catat kehadiran Anda hari ini</p>
        </div>
        <div>
            <span class="text-muted">{{ now()->format('d M Y, H:i') }}</span>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Today's Attendance Card -->
    <div class="card attendance-card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Absensi Hari Ini</h5>
        </div>
        <div class="card-body">
            @if($todayAttendance)
                <div class="text-center py-4">
                    <div class="mb-3">
                        <span class="status-badge status-{{ strtolower($todayAttendance->status) }}">
                            {{ $todayAttendance->status }}
                        </span>
                    </div>
                    @if($todayAttendance->check_in_time)
                        <p class="mb-2"><strong>Waktu Check In:</strong> {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
                    @endif
                    @if($todayAttendance->photo_path)
                        <div class="mt-3">
                            <img src="{{ Storage::url($todayAttendance->photo_path) }}" alt="Foto Check In" class="photo-preview">
                        </div>
                    @endif
                    @if($todayAttendance->absence_reason)
                        <div class="mt-3">
                            <p><strong>Alasan:</strong> {{ $todayAttendance->absence_reason }}</p>
                        </div>
                    @endif
                    <p class="text-muted mt-3">Anda sudah melakukan absensi hari ini.</p>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="mb-4">Silakan pilih salah satu opsi di bawah untuk mencatat absensi:</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <!-- Check In Button -->
                        <button type="button" class="btn btn-checkin" data-bs-toggle="modal" data-bs-target="#checkInModal">
                            <i class="fas fa-check-circle me-2"></i>Check In
                        </button>
                        <!-- Absent Button -->
                        <button type="button" class="btn btn-absent" data-bs-toggle="modal" data-bs-target="#absentModal">
                            <i class="fas fa-times-circle me-2"></i>Absen
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Attendance History -->
    @if($attendanceHistory->count() > 0)
    <div class="card attendance-card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Absensi (30 Hari Terakhir)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Waktu Check In</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceHistory as $attendance)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($attendance->status) }}">
                                    {{ $attendance->status }}
                                </span>
                            </td>
                            <td>
                                @if($attendance->check_in_time)
                                    {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($attendance->absence_reason)
                                    {{ Str::limit($attendance->absence_reason, 50) }}
                                @else
                                    -
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

    <!-- Check In Modal -->
    <div class="modal fade" id="checkInModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Check In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('attendance.check-in') }}" method="POST" enctype="multipart/form-data" id="checkInForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Ambil Foto Selfie <span class="text-danger">*</span></label>
                            
                            <!-- Camera Preview -->
                            <video id="cameraPreview" autoplay playsinline style="display: none;"></video>
                            
                            <!-- Captured Photo Preview -->
                            <img id="capturedPhoto" alt="Captured Photo">
                            
                            <!-- Hidden input untuk menyimpan foto -->
                            <input type="file" id="photo" name="photo" accept="image/*" required style="display: none;">
                            
                            <!-- Camera Controls -->
                            <div id="cameraControls" class="camera-controls" style="display: none;">
                                <button type="button" class="btn btn-capture" id="captureBtn">
                                    <i class="fas fa-camera me-2"></i>Ambil Foto
                                </button>
                                <button type="button" class="btn btn-secondary" id="stopCameraBtn">
                                    <i class="fas fa-stop me-2"></i>Batal
                                </button>
                            </div>
                            
                            <!-- Photo Controls (setelah capture) -->
                            <div id="photoControls" class="camera-controls" style="display: none;">
                                <button type="button" class="btn btn-retake" id="retakeBtn">
                                    <i class="fas fa-redo me-2"></i>Ambil Ulang
                                </button>
                            </div>
                            
                            <!-- Start Camera Button -->
                            <div id="startCameraSection" class="text-center">
                                <button type="button" class="btn btn-primary" id="startCameraBtn">
                                    <i class="fas fa-camera me-2"></i>Buka Kamera
                                </button>
                            </div>
                            
                            <small class="text-muted d-block mt-2">Pastikan wajah Anda terlihat jelas dalam foto</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Perhatian:</strong> Jika check in dilakukan setelah jam 08:00, status akan otomatis menjadi "Terlambat".
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalBtn">Batal</button>
                        <button type="submit" class="btn btn-success" id="submitBtn" disabled>Check In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Absent Modal -->
    <div class="modal fade" id="absentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Absen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('attendance.absent') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reason" class="form-label">Alasan Absen <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reason" name="reason" rows="4" required placeholder="Jelaskan alasan Anda tidak dapat hadir hari ini..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proof" class="form-label">Bukti (Opsional)</label>
                            <input type="file" class="form-control" id="proof" name="proof" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Format: PDF, JPG, PNG. Maksimal 2MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Submit Absen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let stream = null;
    let canvas = null;
    
    // Elements
    const startCameraBtn = document.getElementById('startCameraBtn');
    const cameraPreview = document.getElementById('cameraPreview');
    const capturedPhoto = document.getElementById('capturedPhoto');
    const cameraControls = document.getElementById('cameraControls');
    const photoControls = document.getElementById('photoControls');
    const startCameraSection = document.getElementById('startCameraSection');
    const captureBtn = document.getElementById('captureBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const stopCameraBtn = document.getElementById('stopCameraBtn');
    const photoInput = document.getElementById('photo');
    const submitBtn = document.getElementById('submitBtn');
    const checkInForm = document.getElementById('checkInForm');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const checkInModal = document.getElementById('checkInModal');
    
    // Start camera
    startCameraBtn.addEventListener('click', async function() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'user', // Front camera
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                } 
            });
            
            cameraPreview.srcObject = stream;
            cameraPreview.style.display = 'block';
            cameraControls.style.display = 'flex';
            startCameraSection.style.display = 'none';
            capturedPhoto.style.display = 'none';
            photoControls.style.display = 'none';
        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera dan menggunakan browser yang mendukung.');
        }
    });
    
    // Capture photo
    captureBtn.addEventListener('click', function() {
        canvas = document.createElement('canvas');
        canvas.width = cameraPreview.videoWidth;
        canvas.height = cameraPreview.videoHeight;
        
        const ctx = canvas.getContext('2d');
        ctx.drawImage(cameraPreview, 0, 0);
        
        // Convert canvas to blob and create file
        canvas.toBlob(function(blob) {
            const file = new File([blob], 'selfie.jpg', { type: 'image/jpeg' });
            
            // Create a new FileList-like object
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            photoInput.files = dataTransfer.files;
            
            // Show captured photo
            capturedPhoto.src = canvas.toDataURL('image/jpeg');
            capturedPhoto.style.display = 'block';
            
            // Stop camera stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            
            cameraPreview.style.display = 'none';
            cameraControls.style.display = 'none';
            photoControls.style.display = 'flex';
            submitBtn.disabled = false;
        }, 'image/jpeg', 0.9);
    });
    
    // Retake photo
    retakeBtn.addEventListener('click', function() {
        capturedPhoto.style.display = 'none';
        photoControls.style.display = 'none';
        submitBtn.disabled = true;
        startCameraSection.style.display = 'block';
        
        // Clear photo input
        photoInput.value = '';
    });
    
    // Stop camera
    stopCameraBtn.addEventListener('click', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        
        cameraPreview.style.display = 'none';
        cameraControls.style.display = 'none';
        startCameraSection.style.display = 'block';
        capturedPhoto.style.display = 'none';
        photoControls.style.display = 'none';
        submitBtn.disabled = true;
        photoInput.value = '';
    });
    
    // Clean up when modal is closed
    checkInModal.addEventListener('hidden.bs.modal', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        
        cameraPreview.style.display = 'none';
        cameraControls.style.display = 'none';
        photoControls.style.display = 'none';
        capturedPhoto.style.display = 'none';
        startCameraSection.style.display = 'block';
        submitBtn.disabled = true;
        photoInput.value = '';
    });

</script>
@endpush

@endsection

