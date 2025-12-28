@extends('layouts.dashboard')

@section('title', 'Profile - PT Telkom Indonesia')

@push('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        border-radius: 20px;
        padding: 3rem 2rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .profile-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-10px, -10px) rotate(5deg); }
    }
    
    .profile-avatar-large {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        backdrop-filter: blur(10px);
        border: 4px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 2;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .profile-avatar-large i {
        font-size: 3.5rem;
        color: white;
    }
    
    .profile-name-large {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
        text-align: center;
    }
    
    .profile-email-large {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
        text-align: center;
    }
    
    .info-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #EE2E24;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    .info-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .info-card-header i {
        font-size: 1.5rem;
        color: #EE2E24;
        margin-right: 0.75rem;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(238, 46, 36, 0.1);
        border-radius: 10px;
    }
    
    .info-card-header h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .info-item:hover {
        background: #e9ecef;
    }
    
    .info-item-label {
        font-weight: 600;
        color: #666;
        min-width: 150px;
        margin-right: 1rem;
        display: flex;
        align-items: center;
    }
    
    .info-item-label i {
        margin-right: 0.5rem;
        color: #EE2E24;
        font-size: 0.9rem;
    }
    
    .info-item-value {
        color: #333;
        flex: 1;
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-badge.accepted {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .status-badge.rejected {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .status-badge.finished {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }
    
    .status-badge.pending {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #333;
    }
    
    .password-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #EE2E24;
    }
    
    .password-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .password-card-header i {
        font-size: 1.5rem;
        color: #EE2E24;
        margin-right: 0.75rem;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(238, 46, 36, 0.1);
        border-radius: 10px;
    }
    
    .password-card-header h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #EE2E24;
        box-shadow: 0 0 0 0.2rem rgba(238, 46, 36, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(238, 46, 36, 0.3);
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    @media (max-width: 768px) {
        .profile-hero {
            padding: 2rem 1rem;
        }
        
        .profile-name-large {
            font-size: 1.5rem;
        }
        
        .info-item {
            flex-direction: column;
        }
        
        .info-item-label {
            min-width: auto;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Profile Hero Section -->
    <div class="profile-hero">
        <div class="profile-avatar-large">
            <i class="fas fa-user"></i>
        </div>
        <h2 class="profile-name-large">{{ $user->name ?? 'User' }}</h2>
        <p class="profile-email-large">{{ $user->email ?? '' }}</p>
    </div>

    <div class="row">
        <!-- Biodata / Informasi Peserta -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fas fa-user"></i>
                    <h5>Biodata / Informasi Peserta</h5>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-id-card"></i>
                        <span>Nama</span>
                    </div>
                    <div class="info-item-value">{{ $user->name ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-envelope"></i>
                        <span>Email</span>
                    </div>
                    <div class="info-item-value">{{ $user->email ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-graduation-cap"></i>
                        <span>NIM</span>
                    </div>
                    <div class="info-item-value">{{ $user->nim ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-phone"></i>
                        <span>No HP</span>
                    </div>
                    <div class="info-item-value">{{ $user->phone ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-university"></i>
                        <span>Universitas</span>
                    </div>
                    <div class="info-item-value">{{ $user->university ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-book"></i>
                        <span>Jurusan</span>
                    </div>
                    <div class="info-item-value">{{ $user->major ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-id-badge"></i>
                        <span>NIK (No.KTP)</span>
                    </div>
                    <div class="info-item-value">{{ $user->ktp_number ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Status Pengajuan Magang -->
        @if($application)
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fas fa-clipboard-list"></i>
                    <h5>Status Pengajuan Magang</h5>
                </div>
                <!-- 1. Divisi Penempatan -->
                @if($application->status == 'accepted' || $application->status == 'finished')
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-building"></i>
                        <span>Divisi Penempatan</span>
                    </div>
                    <div class="info-item-value">{{ $application->divisionAdmin->division_name ?? '-' }}</div>
                </div>
                @else
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-building"></i>
                        <span>Divisi Penempatan</span>
                    </div>
                    <div class="info-item-value">-</div>
                </div>
                @endif
                
                <!-- 2. Mentor -->
                @if($application->status == 'accepted' || $application->status == 'finished')
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-user-tie"></i>
                        <span>Mentor</span>
                    </div>
                    <div class="info-item-value">{{ $application->divisionMentor->mentor_name ?? '-' }}</div>
                </div>
                @else
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-user-tie"></i>
                        <span>Mentor</span>
                    </div>
                    <div class="info-item-value">-</div>
                </div>
                @endif
                
                <!-- 3. Bidang Peminatan -->
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-tags"></i>
                        <span>Bidang Peminatan</span>
                    </div>
                    <div class="info-item-value">{{ $application->fieldOfInterest->name ?? '-' }}</div>
                </div>
                
                <!-- 4. Status -->
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-info-circle"></i>
                        <span>Status</span>
                    </div>
                    <div class="info-item-value">
                        @if($application->status == 'accepted')
                            <span class="status-badge accepted">Diterima</span>
                        @elseif($application->status == 'rejected')
                            <span class="status-badge rejected">Ditolak</span>
                        @elseif($application->status == 'finished')
                            <span class="status-badge finished">Selesai</span>
                        @else
                            <span class="status-badge pending">Pending</span>
                        @endif
                    </div>
                </div>
                
                <!-- 5. Tanggal Pengajuan -->
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-calendar"></i>
                        <span>Tanggal Pengajuan</span>
                    </div>
                    <div class="info-item-value">{{ $application->created_at ? $application->created_at->format('d M Y') : '-' }}</div>
                </div>
                
                <!-- 6. Tanggal Mulai Magang -->
                @if($application->start_date)
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-calendar-check"></i>
                        <span>Tanggal Mulai Magang</span>
                    </div>
                    <div class="info-item-value">{{ \Carbon\Carbon::parse($application->start_date)->format('d M Y') }}</div>
                </div>
                @else
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-calendar-check"></i>
                        <span>Tanggal Mulai Magang</span>
                    </div>
                    <div class="info-item-value">-</div>
                </div>
                @endif
                
                <!-- 7. Tanggal Selesai Magang -->
                @if($application->end_date)
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-calendar-times"></i>
                        <span>Tanggal Selesai Magang</span>
                    </div>
                    <div class="info-item-value">{{ \Carbon\Carbon::parse($application->end_date)->format('d M Y') }}</div>
                </div>
                @else
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-calendar-times"></i>
                        <span>Tanggal Selesai Magang</span>
                    </div>
                    <div class="info-item-value">-</div>
                </div>
                @endif
                
                <!-- 8. Surat Penerimaan -->
                @if($application->status == 'accepted' || $application->status == 'finished')
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-file-pdf"></i>
                        <span>Surat Penerimaan</span>
                    </div>
                    <div class="info-item-value">
                        @if($application->acceptance_letter_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($application->acceptance_letter_path))
                            <a href="{{ route('dashboard.acceptance-letter.download') }}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fas fa-download me-1"></i>Download Surat Penerimaan
                            </a>
                        @else
                            <span class="text-muted">Belum tersedia</span>
                        @endif
                    </div>
                </div>
                @else
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-file-pdf"></i>
                        <span>Surat Penerimaan</span>
                    </div>
                    <div class="info-item-value">
                        <span class="text-muted">-</span>
                    </div>
                </div>
                @endif
                @if($application->notes)
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-sticky-note"></i>
                        <span>Catatan</span>
                    </div>
                    <div class="info-item-value">{{ $application->notes }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Ganti Password -->
        <div class="col-12 mb-4">
            <div class="password-card">
                <div class="password-card-header">
                    <i class="fas fa-key"></i>
                    <h5>Ganti Password</h5>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password Saat Ini
                            </label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-key me-2"></i>Password Baru
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-double me-2"></i>Konfirmasi Password Baru
                            </label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Scripts for profile page
</script>
@endpush
@endsection
