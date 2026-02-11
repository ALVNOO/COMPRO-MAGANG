{{--
    ADMIN DASHBOARD RULES SECTION
    Collapsible internship rules with edit modal

    Required variables:
    - $rule: Rule model with content field (nullable)

    Alpine.js variables expected:
    - showRuleContent: boolean for collapse state
    - showEditModal: boolean for modal visibility
--}}

{{-- Rules Card --}}
<div class="rules-card-admin">
    <div class="rules-card-header">
        <div class="rules-card-title">
            <i class="fas fa-gavel"></i>
            <h3>Peraturan Magang</h3>
        </div>
        <div class="rules-actions">
            <button type="button" class="btn-rules secondary" @click="showRuleContent = !showRuleContent">
                <i class="fas" :class="showRuleContent ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                <span x-text="showRuleContent ? 'Tutup' : 'Lihat'"></span>
            </button>
            <button type="button" class="btn-rules primary" @click="showEditModal = true">
                <i class="fas fa-pen"></i>
                Edit
            </button>
        </div>
    </div>
    <div x-show="showRuleContent"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="rules-content">
        @if($rule && $rule->content)
            <p>{!! nl2br(e($rule->content)) !!}</p>
        @else
            <div class="rules-empty">
                <i class="fas fa-file-alt"></i>
                <p>Belum ada peraturan yang ditetapkan</p>
            </div>
        @endif
    </div>
</div>

{{-- Edit Rule Modal --}}
<div x-show="showEditModal" style="display: none;">
    <div class="modal-backdrop-admin" @click="showEditModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"></div>

    <div class="modal-container-admin">
        <div class="modal-box-admin"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">

            <div class="modal-header-admin">
                <div class="modal-title-admin">
                    <i class="fas fa-gavel"></i>
                    <h5>Edit Peraturan</h5>
                </div>
                <button class="modal-close-admin" @click="showEditModal = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.rules.update') }}">
                @csrf
                <div class="modal-body-admin">
                    <label for="content">Isi Peraturan</label>
                    <textarea name="content" id="content" rows="10" required
                        placeholder="Masukkan peraturan magang...">{{ old('content', $rule ? $rule->content : '') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-footer-admin">
                    <button type="button" class="btn-rules secondary" @click="showEditModal = false">
                        Batal
                    </button>
                    <button type="submit" class="btn-rules primary">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
