{{--
    MENTOR DASHBOARD CHARTS SECTION
    Participant completion and distribution charts
--}}

<div class="charts-grid">
    {{-- Participant Completion Bar Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h5 class="chart-title">Persentase Penyelesaian Tugas per Peserta</h5>
        </div>
        <div class="chart-body">
            <div class="chart-loading active">
                <div class="chart-loading-spinner"></div>
            </div>
            <canvas id="participantCompletionChart" style="max-height: 280px;"></canvas>
        </div>
    </div>

    {{-- Completion Distribution Doughnut Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </div>
            <h5 class="chart-title">Distribusi Penyelesaian</h5>
        </div>
        <div class="chart-body">
            <div class="chart-loading active">
                <div class="chart-loading-spinner"></div>
            </div>
            <canvas id="completionDistributionChart" style="max-height: 280px;"></canvas>
        </div>
    </div>
</div>
