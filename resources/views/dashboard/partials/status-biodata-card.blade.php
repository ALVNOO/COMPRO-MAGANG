{{--
    STATUS BIODATA CARD
    Displays applicant's personal information

    Required variables:
    - $user: User model with name, email, nim, phone, university, major
--}}

<div class="info-card" data-animate>
    <div class="card-header">
        <div class="card-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <h4 class="card-title">Biodata Pemohon</h4>
    </div>
    <div class="card-body">
        <div class="data-grid">
            <div class="data-item">
                <div class="data-label">Nama Lengkap</div>
                <p class="data-value">{{ $user->name ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">Email</div>
                <p class="data-value">{{ $user->email ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">NIM</div>
                <p class="data-value">{{ $user->nim ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">No. Telepon</div>
                <p class="data-value">{{ $user->phone ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">Universitas/Sekolah</div>
                <p class="data-value">{{ $user->university ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">Jurusan</div>
                <p class="data-value">{{ $user->major ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
