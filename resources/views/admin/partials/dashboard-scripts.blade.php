{{--
    ADMIN DASHBOARD SCRIPTS
    Intersection Observer, Counter Animation, Chart.js initialization

    Required variables:
    - $statusDistribution: Array with pending, accepted, rejected, finished counts
    - $applicationsOverTime: Array of {date, count} for line chart
    - $applicationsPerDivision: Array of {name, count} for bar chart
--}}

{{-- Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // INTERSECTION OBSERVER FOR ANIMATIONS
    // ============================================
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');

                // Trigger counter animation for stat cards
                if (entry.target.classList.contains('stat-card-admin')) {
                    animateCounter(entry.target.querySelector('.stat-card-value'));
                }
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.stat-card-admin, .chart-card-admin, .quick-actions-admin, .activity-feed-admin, .activity-item-admin, .table-card-admin, .rules-card-admin').forEach(el => {
        observer.observe(el);
    });

    // ============================================
    // COUNTER ANIMATION
    // ============================================
    function animateCounter(element) {
        if (!element || element.dataset.animated) return;

        element.dataset.animated = 'true';

        const target = parseFloat(element.dataset.target) || 0;
        const prefix = element.textContent.includes('+') ? '+' : '';
        const duration = 1500;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = target * easeOutQuart;

            element.textContent = prefix + Math.floor(current);

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.textContent = prefix + target;
            }
        }

        requestAnimationFrame(update);
    }

    // Animate hero stat value
    const heroStatValue = document.querySelector('.hero-stat-value');
    if (heroStatValue) {
        setTimeout(() => {
            animateCounter(heroStatValue);
        }, 500);
    }

    // ============================================
    // CHART.JS INITIALIZATION
    // ============================================
    // Remove loading spinners after delay
    setTimeout(() => {
        document.querySelectorAll('.chart-loading-admin').forEach(el => {
            el.classList.remove('active');
        });
    }, 800);

    // Status Distribution Pie Chart
    const statusPieCtx = document.getElementById('statusPieChart');
    if (statusPieCtx) {
        new Chart(statusPieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diterima', 'Ditolak', 'Selesai'],
                datasets: [{
                    data: [
                        {{ $statusDistribution['pending'] ?? 0 }},
                        {{ $statusDistribution['accepted'] ?? 0 }},
                        {{ $statusDistribution['rejected'] ?? 0 }},
                        {{ $statusDistribution['finished'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.85)',
                        'rgba(16, 185, 129, 0.85)',
                        'rgba(239, 68, 68, 0.85)',
                        'rgba(139, 92, 246, 0.85)'
                    ],
                    hoverBackgroundColor: [
                        '#F59E0B',
                        '#10B981',
                        '#EF4444',
                        '#8B5CF6'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '600' },
                            color: '#475569'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 14,
                        cornerRadius: 10,
                        titleFont: { weight: '700', size: 13 },
                        bodyFont: { size: 12 },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                }
            }
        });
    }

    // Applications Over Time Line Chart
    const lineCtx = document.getElementById('applicationsLineChart');
    if (lineCtx) {
        const applicationsData = @json($applicationsOverTime);
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: applicationsData.map(d => d.date),
                datasets: [{
                    label: 'Pengajuan',
                    data: applicationsData.map(d => d.count),
                    borderColor: '#EE2E24',
                    backgroundColor: 'rgba(238, 46, 36, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#EE2E24',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 14,
                        cornerRadius: 10,
                        titleFont: { weight: '700', size: 13 },
                        bodyFont: { size: 12 },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 11, weight: '500' },
                            color: '#64748B'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            font: { size: 10, weight: '500' },
                            color: '#64748B'
                        }
                    }
                }
            }
        });
    }

    // Applications Per Division Bar Chart
    const barCtx = document.getElementById('divisionBarChart');
    if (barCtx) {
        const divisionData = @json($applicationsPerDivision);
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: divisionData.map(d => d.name.length > 20 ? d.name.substring(0, 20) + '...' : d.name),
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: divisionData.map(d => d.count),
                    backgroundColor: 'rgba(238, 46, 36, 0.8)',
                    hoverBackgroundColor: '#EE2E24',
                    borderColor: 'transparent',
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 14,
                        cornerRadius: 10,
                        titleFont: { weight: '700', size: 13 },
                        bodyFont: { size: 12 },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 11, weight: '500' },
                            color: '#64748B'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            font: { size: 11, weight: '500' },
                            color: '#64748B'
                        }
                    }
                }
            }
        });
    }
});
</script>
