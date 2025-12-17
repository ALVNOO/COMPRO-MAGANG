@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Logbook Peserta Magang</h2>
        <p class="text-sm text-[#000000]">Lihat logbook yang sudah diisi oleh peserta magang</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl p-6 mb-6">
        <form method="GET" action="{{ route('admin.logbook') }}" id="filterForm" class="row g-3">
            <div class="col-md-4">
                <label for="division_id" class="form-label font-semibold">Filter Divisi</label>
                <select class="form-select" id="division_id" name="division_id">
                    <option value="">All Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                            {{ $division->division_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="mentor_id" class="form-label font-semibold">Filter Pembimbing</label>
                <select class="form-select" id="mentor_id" name="mentor_id">
                    <option value="">All Mentor</option>
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id }}" {{ $filterMentor == $mentor->id ? 'selected' : '' }}>
                            {{ $mentor->mentor_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="{{ route('admin.logbook') }}" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Participants List -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-book text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Daftar Peserta Magang</h5>
        </div>
        <div class="p-6">
            @if($participants->count() > 0)
            <div class="participants-container">
                @foreach($participants as $index => $participant)
                <div class="participant-card" style="border: 1px solid #e3e3e0; border-radius: 12px; margin-bottom: 1rem; overflow: hidden;">
                    <div class="participant-header" 
                         data-target="logbook-admin-{{ $index }}"
                         style="background: #fff; padding: 1rem 1.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.1rem;">
                                {{ strtoupper(substr($participant['user']->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1b1b18; margin-bottom: 0.25rem;">{{ $participant['user']->name }}</div>
                                <div style="font-size: 0.85rem; color: #6c757d;">{{ $participant['user']->email }}</div>
                                @if(isset($participant['application']) && $participant['application']->divisionAdmin)
                                <div style="font-size: 0.8rem; color: #6c757d;">
                                    <i class="fas fa-building me-1"></i>{{ $participant['application']->divisionAdmin->division_name }}
                                </div>
                                @endif
                                @if(isset($participant['application']) && $participant['application']->divisionMentor)
                                <div style="font-size: 0.8rem; color: #6c757d;">
                                    <i class="fas fa-user-tie me-1"></i>Pembimbing: {{ $participant['application']->divisionMentor->mentor_name }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%); color: white; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                {{ $participant['logbooks']->count() }} Logbook
                            </span>
                            <i class="fas fa-chevron-down toggle-icon" style="color: #6c757d; transition: transform 0.3s;"></i>
                        </div>
                    </div>
                    <div class="logbook-content-wrapper" id="logbook-admin-{{ $index }}" style="display: none; background: #f8f9fa; padding: 1.5rem; border-top: 1px solid #e3e3e0;">
                        @if($participant['logbooks']->count() > 0)
                        <div class="table-responsive" style="background: white; border-radius: 8px; overflow: hidden;">
                            <table class="table table-hover mb-0">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="width: 20%; font-weight: 600; color: #495057; border-bottom: 2px solid #e3e3e0;">Tanggal</th>
                                        <th style="width: 80%; font-weight: 600; color: #495057; border-bottom: 2px solid #e3e3e0;">Isi Logbook</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participant['logbooks'] as $logbook)
                                    <tr>
                                        <td class="align-middle">
                                            <strong>{{ $logbook->date ? $logbook->date->format('d M Y') : '-' }}</strong>
                                        </td>
                                        <td class="align-middle">
                                            <div style="white-space: pre-wrap; word-wrap: break-word;">{{ $logbook->content ?? '-' }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div style="text-align: center; padding: 2rem; color: #6c757d;">
                            <i class="fas fa-book-open" style="font-size: 3rem; margin-bottom: 1rem; color: #dee2e6; display: block;"></i>
                            <p class="mb-0">Peserta ini belum mengisi logbook.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada data logbook untuk filter yang dipilih.
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .participant-header:hover {
        background-color: #f8f9fa !important;
    }
    .participant-header.active {
        background-color: #FEF2F2 !important;
        border-bottom: 2px solid #B91C1C;
    }
    .participant-header.active .toggle-icon {
        transform: rotate(180deg);
        color: #B91C1C !important;
    }
    .participant-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion toggle for participant cards
    const headers = document.querySelectorAll('.participant-header');
    
    headers.forEach(header => {
        header.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            
            if (content) {
                // Toggle active class on header
                this.classList.toggle('active');
                
                // Toggle display on content
                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                } else {
                    content.style.display = 'none';
                }
            }
        });
    });

    // Update mentor dropdown when division changes
    document.getElementById('division_id').addEventListener('change', function() {
        const divisionId = this.value;
        const mentorSelect = document.getElementById('mentor_id');
        const currentMentorId = '{{ $filterMentor }}';
        
        // Fetch mentors for selected division
        fetch(`{{ route('admin.logbook.mentors') }}?division_id=${divisionId}`)
            .then(response => response.json())
            .then(data => {
                mentorSelect.innerHTML = '<option value="">All Mentor</option>';
                data.mentors.forEach(mentor => {
                    const option = document.createElement('option');
                    option.value = mentor.id;
                    option.textContent = mentor.mentor_name;
                    if (mentor.id == currentMentorId) {
                        option.selected = true;
                    }
                    mentorSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
</script>
@endsection
