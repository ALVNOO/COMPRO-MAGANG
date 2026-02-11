{{--
    ADMIN DASHBOARD CHARTS SECTION
    Status distribution pie chart and applications line chart

    Required variables:
    - None (Chart data is passed via JavaScript)
--}}

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Status Distribution Pie Chart --}}
    <div class="chart-card-admin">
        <div class="chart-card-header">
            <div class="chart-card-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <h3 class="chart-card-title">Distribusi Status</h3>
        </div>
        <div class="chart-card-body">
            <div class="chart-loading-admin active">
                <div class="chart-loading-spinner"></div>
            </div>
            <canvas id="statusPieChart" height="220"></canvas>
        </div>
    </div>

    {{-- Applications Over Time Line Chart --}}
    <div class="chart-card-admin lg:col-span-2">
        <div class="chart-card-header">
            <div class="chart-card-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="chart-card-title">Pengajuan 30 Hari Terakhir</h3>
        </div>
        <div class="chart-card-body">
            <div class="chart-loading-admin active">
                <div class="chart-loading-spinner"></div>
            </div>
            <canvas id="applicationsLineChart" height="150"></canvas>
        </div>
    </div>
</div>
