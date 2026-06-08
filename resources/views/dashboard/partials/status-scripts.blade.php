{{-- STATUS PAGE SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stagger animation delays for cards and stats
    document.querySelectorAll('.sp-card').forEach((el, i) => {
        el.style.animationDelay = (0.15 + i * 0.05) + 's';
        el.classList.add('sp-anim');
    });
    // Animate progress bar fills after page load
    setTimeout(function() {
        document.querySelectorAll('.sp-prog-bar-fill').forEach(function(bar) {
            var w = bar.style.width;
            bar.style.width = '0';
            bar.style.transition = 'width .8s cubic-bezier(.16,1,.3,1)';
            requestAnimationFrame(function() { bar.style.width = w; });
        });
    }, 300);

    // AJAX upload for required documents — no page refresh
    function attachDocInput(input) {
        input.addEventListener('change', function() {
            if (!this.files.length) return;

            var file  = this.files[0];
            var form  = this.closest('.sp-req-doc-form');
            var card  = this.closest('.sp-req-doc-card');
            var label = this.closest('.sp-req-doc-upload-label');
            var btn   = label ? label.querySelector('.sp-req-doc-upload-btn') : null;

            // Client-side guard: PDF only, max 2 MB
            if (!file.name.toLowerCase().endsWith('.pdf')) {
                showDocToast('error', 'File harus berformat PDF.');
                this.value = ''; return;
            }
            if (file.size > 2 * 1024 * 1024) {
                showDocToast('error', 'Ukuran file tidak boleh lebih dari 2 MB.');
                this.value = ''; return;
            }

            // Show uploading state
            card.classList.add('is-uploading');
            if (btn) btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i><span>Mengunggah…</span>';

            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function(res) {
                return res.json().then(function(data) {
                    return { ok: res.ok, data: data };
                });
            })
            .then(function(result) {
                card.classList.remove('is-uploading');

                if (result.ok && result.data.success) {
                    markDocAsDone(card, result.data.url);
                    showDocToast('success', result.data.message || 'Dokumen berhasil diunggah.');
                } else {
                    var msg = result.data.message
                        || (result.data.errors ? Object.values(result.data.errors)[0][0] : null)
                        || 'Gagal mengunggah dokumen.';
                    if (btn) btn.innerHTML = '<i class="fas fa-upload"></i><span class="sp-req-doc-file-label">Unggah PDF</span>';
                    showDocToast('error', msg);
                }
            })
            .catch(function() {
                card.classList.remove('is-uploading');
                if (btn) btn.innerHTML = '<i class="fas fa-upload"></i><span class="sp-req-doc-file-label">Unggah PDF</span>';
                showDocToast('error', 'Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    }

    function markDocAsDone(card, fileUrl) {
        // Card state
        card.classList.add('is-done');

        // Icon
        var icon = card.querySelector('.sp-req-doc-icon');
        if (icon) icon.className = 'sp-req-doc-icon done';

        // Status text
        var statusEl = card.querySelector('.sp-req-doc-status');
        if (statusEl) statusEl.innerHTML = '<i class="fas fa-check-circle"></i> Sudah diunggah';

        // Replace/insert "Lihat dokumen" link
        var footer = card.querySelector('.sp-req-doc-footer');
        var existingView = footer ? footer.querySelector('.sp-req-doc-view') : null;
        if (!existingView && footer) {
            var viewLink = document.createElement('a');
            viewLink.href = fileUrl;
            viewLink.target = '_blank';
            viewLink.rel = 'noopener';
            viewLink.className = 'sp-req-doc-view';
            viewLink.innerHTML = '<i class="fas fa-eye"></i> Lihat dokumen';
            footer.insertBefore(viewLink, footer.firstChild);
        } else if (existingView) {
            existingView.href = fileUrl;
        }

        // Switch upload button to Ganti style
        var uploadLabel = card.querySelector('.sp-req-doc-upload-label');
        var uploadBtn   = card.querySelector('.sp-req-doc-upload-btn');
        if (uploadLabel) uploadLabel.classList.add('is-replace');
        if (uploadBtn)   uploadBtn.innerHTML = '<i class="fas fa-sync-alt"></i><span class="sp-req-doc-file-label">Ganti Dokumen</span>';

        // Re-attach listener to the same input for re-uploads
        var newInput = card.querySelector('.sp-req-doc-input');
        if (newInput) attachDocInput(newInput);

        // Update counter
        var done = document.querySelectorAll('.sp-req-doc-card.is-done').length;
        var countEl = document.querySelector('.sp-req-docs-progress-count');
        if (countEl) countEl.textContent = done + '/3';

        if (done === 3) {
            // Hide warning
            var warn = document.querySelector('.sp-req-docs-warning');
            if (warn) warn.style.display = 'none';

            // Enable the Siap Magang button
            var siapBtn = document.querySelector('.sp-btn-siap-magang');
            if (siapBtn) {
                siapBtn.disabled = false;
                siapBtn.removeAttribute('title');
            }

            // Update hint text below button
            var hint = document.querySelector('.sp-siap-hint');
            if (hint) {
                hint.classList.remove('sp-siap-hint-warn');
                hint.textContent = 'Klik tombol di atas untuk membuka akses penuh ke dashboard magang Anda';
            }
        }
    }

    function showDocToast(type, message) {
        var existing = document.querySelector('.sp-doc-toast');
        if (existing) existing.remove();

        var toast = document.createElement('div');
        toast.className = 'sp-doc-toast sp-doc-toast--' + type;
        var icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
        toast.innerHTML = '<i class="fas fa-' + icon + '"></i> ' + message;
        document.body.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() { toast.remove(); }, 300);
        }, 3500);
    }

    document.querySelectorAll('.sp-req-doc-input').forEach(attachDocInput);
});
</script>
