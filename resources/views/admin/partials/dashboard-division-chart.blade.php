{{--
    ADMIN DASHBOARD DIVISION BAR CHART
    Applications per division visualization

    Required variables:
    - None (Chart data is passed via JavaScript)
--}}

<div class="chart-card-admin">
    <div class="chart-card-header">
        <div class="chart-card-icon">
            <i class="fas fa-chart-bar"></i>
        </div>
        <h3 class="chart-card-title">Pengajuan per Divisi (Top 10)</h3>
    </div>
    <div class="chart-card-body">
        <div class="chart-loading-admin active">
            <div class="chart-loading-spinner"></div>
        </div>
        <canvas id="divisionBarChart" height="120"></canvas>
    </div>
</div>
