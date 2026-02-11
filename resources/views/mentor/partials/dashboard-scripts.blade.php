{{--
    MENTOR DASHBOARD SCRIPTS
    Intersection Observer, Counter Animation, Chart.js initialization

    Required variables:
    - $participantCompletionData: Array for bar chart
    - $completionDistributionData: Array for doughnut chart
--}}

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
                if (entry.target.classList.contains('stat-card')) {
                    animateCounter(entry.target);
                }
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.stat-card, .chart-card, .activity-card, .activity-item, .quick-actions-card, .action-card').forEach(el => {
        observer.observe(el);
    });

    // ============================================
    // COUNTER ANIMATION
    // ============================================
    function animateCounter(card) {
        const valueEl = card.querySelector('.stat-value');
        if (!valueEl || valueEl.dataset.animated) return;

        valueEl.dataset.animated = 'true';

        const target = parseFloat(valueEl.dataset.target) || 0;
        const isDecimal = valueEl.dataset.decimal === 'true';
        const suffix = valueEl.dataset.suffix || '';
        const duration = 1500;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function for smooth animation
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = target * easeOutQuart;

            if (isDecimal) {
                valueEl.textContent = current.toFixed(1) + suffix;
            } else {
                valueEl.textContent = Math.floor(current) + suffix;
            }

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                if (isDecimal) {
                    valueEl.textContent = target.toFixed(1) + suffix;
                } else {
                    valueEl.textContent = target + suffix;
                }
            }
        }

        requestAnimationFrame(update);
    }

    // ============================================
    // CHART.JS INITIALIZATION
    // ============================================
    if (typeof Chart !== 'undefined') {
        // Remove loading spinners after delay
        setTimeout(() => {
            document.querySelectorAll('.chart-loading').forEach(el => {
                el.classList.remove('active');
            });
        }, 800);

        // Participant Completion Chart (Bar Chart)
        const participantCompletionCtx = document.getElementById('participantCompletionChart');
        if (participantCompletionCtx) {
            const participantData = @json($participantCompletionData);
            const labels = participantData.map(d => d.name);
            const percentages = participantData.map(d => d.percentage);

            const backgroundColors = percentages.map(p => {
                if (p === 100) return 'rgba(16, 185, 129, 0.8)';
                if (p >= 75) return 'rgba(6, 182, 212, 0.8)';
                if (p >= 50) return 'rgba(245, 158, 11, 0.8)';
                if (p >= 25) return 'rgba(249, 115, 22, 0.8)';
                return 'rgba(239, 68, 68, 0.8)';
            });

            const hoverColors = percentages.map(p => {
                if (p === 100) return '#10B981';
                if (p >= 75) return '#06B6D4';
                if (p >= 50) return '#F59E0B';
                if (p >= 25) return '#F97316';
                return '#EF4444';
            });

            new Chart(participantCompletionCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Persentase Selesai',
                        data: percentages,
                        backgroundColor: backgroundColors,
                        hoverBackgroundColor: hoverColors,
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
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const index = context.dataIndex;
                                    const participant = participantData[index];
                                    return [
                                        `Penyelesaian: ${participant.percentage}%`,
                                        `Selesai: ${participant.completed} dari ${participant.total} tugas`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                font: { size: 11, weight: '500' },
                                color: '#64748B'
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: { size: 11, weight: '500' },
                                color: '#64748B'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Completion Distribution Chart (Doughnut Chart)
        const completionDistCtx = document.getElementById('completionDistributionChart');
        if (completionDistCtx) {
            const distributionData = @json($completionDistributionData);
            const completedAllCount = distributionData.completedAll.length;
            const incompleteCount = distributionData.incomplete.length;

            new Chart(completionDistCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai Semua', 'Belum Selesai'],
                    datasets: [{
                        data: [completedAllCount, incompleteCount],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.85)',
                            'rgba(245, 158, 11, 0.85)'
                        ],
                        hoverBackgroundColor: [
                            '#10B981',
                            '#F59E0B'
                        ],
                        borderWidth: 0,
                        hoverOffset: 8
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
                                padding: 24,
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
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} peserta (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }
});
</script>
