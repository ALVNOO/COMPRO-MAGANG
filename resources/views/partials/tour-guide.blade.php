@if(!Auth::user()->tour_completed)
<!-- Tour Guide System -->
<div id="tourOverlay" class="tour-overlay"></div>
<div id="tourSpotlight" class="tour-spotlight tour-highlight"></div>
<div id="tourTooltip" class="tour-tooltip" style="display: none;">
    <div class="tour-tooltip-header">
        <div class="flex-grow-1">
            <h5 class="tour-tooltip-title" id="tourTitle"></h5>
            <div class="tour-tooltip-step" id="tourStep"></div>
        </div>
    </div>
    <div class="tour-progress">
        <div class="tour-progress-bar" id="tourProgressBar"></div>
    </div>
    <div class="tour-tooltip-content" id="tourContent"></div>
    <div class="tour-tooltip-footer">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="tourSkip">
            <i class="fas fa-times me-1"></i>Lewati
        </button>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-primary" id="tourPrev" style="display: none;">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </button>
            <button type="button" class="btn btn-sm btn-primary" id="tourNext">
                Selanjutnya<i class="fas fa-arrow-right ms-1"></i>
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Tour Guide Styles */
    .tour-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9998;
        display: none;
    }

    .tour-overlay.active {
        display: block;
    }

    .tour-spotlight {
        position: absolute;
        z-index: 9999;
        pointer-events: none;
        border: 3px solid #EE2E24;
        border-radius: 8px;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7), 0 0 20px rgba(238, 46, 36, 0.5);
        transition: all 0.3s ease;
    }

    .tour-tooltip {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        min-width: 300px;
    }

    .tour-tooltip-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .tour-tooltip-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #EE2E24;
        margin: 0;
    }

    .tour-tooltip-step {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 600;
    }

    .tour-tooltip-content {
        color: #333;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .tour-tooltip-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
    }

    .tour-progress {
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .tour-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #EE2E24, #F60000);
        transition: width 0.3s ease;
    }

    .tour-highlight {
        animation: pulse-highlight 2s infinite;
    }

    @keyframes pulse-highlight {
        0%, 100% {
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7), 0 0 20px rgba(238, 46, 36, 0.5);
        }
        50% {
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7), 0 0 30px rgba(238, 46, 36, 0.8);
        }
    }
</style>
@endpush

@push('scripts')
<script>
function initTourGuide(steps) {
    if (typeof steps === 'undefined' || steps.length === 0) return;

    let currentStep = 0;
    const overlay = document.getElementById('tourOverlay');
    const spotlight = document.getElementById('tourSpotlight');
    const tooltip = document.getElementById('tourTooltip');
    const tourTitle = document.getElementById('tourTitle');
    const tourContent = document.getElementById('tourContent');
    const tourStep = document.getElementById('tourStep');
    const tourProgressBar = document.getElementById('tourProgressBar');
    const btnNext = document.getElementById('tourNext');
    const btnPrev = document.getElementById('tourPrev');
    const btnSkip = document.getElementById('tourSkip');

    function showStep(stepIndex) {
        if (stepIndex < 0 || stepIndex >= steps.length) return;

        const step = steps[stepIndex];
        let targetElement = document.querySelector(step.element);

        // Fallback if element not found
        if (!targetElement) {
            console.warn('Element not found:', step.element);
            if (stepIndex < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
                return;
            } else {
                endTour();
                return;
            }
        }

        // Update content
        tourTitle.textContent = step.title;
        tourContent.textContent = step.content;
        tourStep.textContent = `Langkah ${stepIndex + 1} dari ${steps.length}`;

        // Update progress bar
        const progress = ((stepIndex + 1) / steps.length) * 100;
        tourProgressBar.style.width = progress + '%';

        // Show/hide prev button
        btnPrev.style.display = stepIndex > 0 ? 'block' : 'none';

        // Update next button text
        btnNext.innerHTML = stepIndex === steps.length - 1
            ? 'Selesai<i class="fas fa-check ms-1"></i>'
            : 'Selanjutnya<i class="fas fa-arrow-right ms-1"></i>';

        // Position spotlight
        const rect = targetElement.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        spotlight.style.top = (rect.top + scrollTop - 10) + 'px';
        spotlight.style.left = (rect.left + scrollLeft - 10) + 'px';
        spotlight.style.width = (rect.width + 20) + 'px';
        spotlight.style.height = (rect.height + 20) + 'px';

        // Show tooltip (fixed position di pojok kanan atas)
        tooltip.style.display = 'block';

        // Scroll element into view
        targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Show overlay
        overlay.classList.add('active');
    }

    function endTour() {
        // Hide all tour elements
        overlay.classList.remove('active');
        overlay.style.display = 'none';
        tooltip.style.display = 'none';
        spotlight.style.display = 'none';
        spotlight.style.width = '0';
        spotlight.style.height = '0';

        // Mark tour as completed
        fetch('{{ route("dashboard.tour.complete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => {
            // Ensure everything is hidden
            setTimeout(() => {
                overlay.style.display = 'none';
                tooltip.style.display = 'none';
                spotlight.style.display = 'none';
            }, 100);
        });
    }

    // Event listeners
    btnNext.addEventListener('click', function() {
        if (currentStep === steps.length - 1) {
            endTour();
        } else {
            currentStep++;
            showStep(currentStep);
        }
    });

    btnPrev.addEventListener('click', function() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    btnSkip.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin melewati panduan ini? Anda dapat mengaksesnya kembali dari menu Profile.')) {
            endTour();
        }
    });

    // Start tour after a short delay
    setTimeout(function() {
        showStep(0);
    }, 1000);
}
</script>
@endpush
@endif
