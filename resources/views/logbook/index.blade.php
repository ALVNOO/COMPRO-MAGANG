@extends('layouts.dashboard')

@section('title', 'Logbook - PT Telkom Indonesia')

@push('styles')
<style>
    .logbook-card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    .btn-save {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        color: white;
    }
    .btn-cancel {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        color: white;
    }
    .btn-edit {
        background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
        border: none;
        color: #212529;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
        color: #212529;
    }
    .btn-delete {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        color: white;
    }
    .btn-add {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(238, 46, 36, 0.3);
        color: white;
    }
    .logbook-row {
        transition: background-color 0.3s;
    }
    .logbook-row:hover {
        background-color: rgba(238, 46, 36, 0.05);
    }
    .logbook-content {
        min-height: 80px;
        resize: vertical;
    }
    .empty-row {
        background-color: #f8f9fa;
    }
    .action-buttons {
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Logbook</h1>
            <p class="text-muted">Catat aktivitas harian magang Anda</p>
        </div>
        <div>
            <button type="button" class="btn btn-add" id="btnAddLogbook">
                <i class="fas fa-plus me-2"></i>Tambah Logbook
            </button>
        </div>
    </div>

    <!-- Logbook Table -->
    <div class="card logbook-card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-book me-2"></i>Daftar Logbook</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="logbookTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 65%;">Isi Logbook</th>
                            <th style="width: 20%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="logbookBody">
                        @foreach($logbooks as $logbook)
                        <tr class="logbook-row" data-id="{{ $logbook->id }}">
                            <td class="align-middle">
                                <strong>{{ $logbook->date->format('d M Y') }}</strong>
                            </td>
                            <td class="align-middle">
                                <div style="white-space: pre-wrap; word-wrap: break-word;">{{ $logbook->content }}</div>
                            </td>
                            <td class="align-middle text-center action-buttons">
                                <button type="button" class="btn btn-sm btn-edit btn-edit-logbook" 
                                        data-id="{{ $logbook->id }}"
                                        data-date="{{ $logbook->date->format('Y-m-d') }}"
                                        data-content="{{ $logbook->content }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-delete btn-delete-logbook" 
                                        data-id="{{ $logbook->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        
                        @php $emptyRows = max(0, 10 - $logbooks->count()); @endphp
                        @for($i = 0; $i < $emptyRows; $i++)
                        <tr class="logbook-row empty-row new-entry-row" style="display: none;">
                            <td class="align-middle">
                                <input type="date" class="form-control input-date" required>
                            </td>
                            <td class="align-middle">
                                <textarea class="form-control logbook-content input-content" rows="3" placeholder="Tulis aktivitas Anda hari ini..." required></textarea>
                            </td>
                            <td class="align-middle text-center action-buttons">
                                <button type="button" class="btn btn-sm btn-save btn-save-new">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-cancel btn-cancel-new">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Logbook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="editDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContent" class="form-label">Isi Logbook</label>
                        <textarea class="form-control" id="editContent" rows="6" required placeholder="Tulis aktivitas Anda..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus logbook ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logbookBody = document.getElementById('logbookBody');
    const btnAddLogbook = document.getElementById('btnAddLogbook');
    let visibleEmptyRows = 0;
    const maxEmptyRows = {{ $emptyRows }};
    let deleteId = null;
    
    // Show first empty row initially
    showNextEmptyRow();
    
    function showNextEmptyRow() {
        const emptyRows = document.querySelectorAll('.new-entry-row');
        let shown = false;
        
        for (let row of emptyRows) {
            if (row.style.display === 'none') {
                row.style.display = '';
                visibleEmptyRows++;
                shown = true;
                break;
            }
        }
        
        // If no more empty rows, create a new one
        if (!shown) {
            addNewEmptyRow();
        }
    }
    
    function addNewEmptyRow() {
        const newRow = document.createElement('tr');
        newRow.className = 'logbook-row empty-row new-entry-row';
        newRow.innerHTML = `
            <td class="align-middle">
                <input type="date" class="form-control input-date" required>
            </td>
            <td class="align-middle">
                <textarea class="form-control logbook-content input-content" rows="3" placeholder="Tulis aktivitas Anda hari ini..." required></textarea>
            </td>
            <td class="align-middle text-center action-buttons">
                <button type="button" class="btn btn-sm btn-save btn-save-new">
                    <i class="fas fa-save"></i>
                </button>
                <button type="button" class="btn btn-sm btn-cancel btn-cancel-new">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        `;
        logbookBody.appendChild(newRow);
        visibleEmptyRows++;
    }
    
    // Add logbook button
    btnAddLogbook.addEventListener('click', function() {
        showNextEmptyRow();
    });
    
    // Save new logbook
    logbookBody.addEventListener('click', async function(e) {
        if (e.target.closest('.btn-save-new')) {
            const row = e.target.closest('tr');
            const dateInput = row.querySelector('.input-date');
            const contentInput = row.querySelector('.input-content');
            const saveBtn = row.querySelector('.btn-save-new');
            
            if (!dateInput.value || !contentInput.value.trim()) {
                alert('Mohon isi tanggal dan isi logbook.');
                return;
            }
            
            // Disable button while saving
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            try {
                // Save via AJAX
                const response = await fetch('{{ route("logbook.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        date: dateInput.value,
                        content: contentInput.value
                    })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Reload page to show new entry
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menyimpan logbook.');
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<i class="fas fa-save"></i>';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan logbook.');
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i>';
            }
        }
        
        // Cancel new logbook
        if (e.target.closest('.btn-cancel-new')) {
            const row = e.target.closest('tr');
            row.querySelector('.input-date').value = '';
            row.querySelector('.input-content').value = '';
            row.style.display = 'none';
            visibleEmptyRows--;
        }
        
        // Edit logbook
        if (e.target.closest('.btn-edit-logbook')) {
            const btn = e.target.closest('.btn-edit-logbook');
            document.getElementById('editId').value = btn.dataset.id;
            document.getElementById('editDate').value = btn.dataset.date;
            document.getElementById('editContent').value = btn.dataset.content;
            
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }
        
        // Delete logbook
        if (e.target.closest('.btn-delete-logbook')) {
            const btn = e.target.closest('.btn-delete-logbook');
            deleteId = btn.dataset.id;
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    });
    
    // Edit form submit
    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const id = document.getElementById('editId').value;
        const date = document.getElementById('editDate').value;
        const content = document.getElementById('editContent').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        
        // Disable button while saving
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        
        try {
            const response = await fetch(`/logbook/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ date, content })
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menyimpan perubahan.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan Perubahan';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan perubahan.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Perubahan';
        }
    });
    
    // Confirm delete
    document.getElementById('confirmDelete').addEventListener('click', async function() {
        if (!deleteId) return;
        
        const deleteBtn = this;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
        
        try {
            const response = await fetch(`/logbook/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menghapus logbook.');
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = 'Hapus';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus logbook.');
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = 'Hapus';
        }
    });
});
</script>
@endpush

@endsection
