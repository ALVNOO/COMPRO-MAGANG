<?php

namespace App\Services\Report;

use App\Models\InternshipApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Get report data with filters.
     */
    public function getReportData(Request $request): array
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $period = $request->input('period');
        $week = $request->input('week');

        $dateRange = $this->calculateDateRange($period, $year, $month, $week);

        $query = InternshipApplication::query()
            ->whereIn('status', ['accepted', 'finished'])
            ->whereNotNull('start_date')
            ->with(['user.certificates', 'divisionAdmin']);

        // Filter by date range - show participants if there's overlap between internship and selected period
        $query->where(function ($q) use ($dateRange) {
            $q->where(function ($sub) use ($dateRange) {
                $sub->whereDate('start_date', '<=', $dateRange['end']->toDateString())
                    ->where(function ($sub2) use ($dateRange) {
                        $sub2->whereNull('end_date')
                            ->orWhereDate('end_date', '>=', $dateRange['start']->toDateString());
                    });
            });
        });

        $applications = $query->orderBy('start_date', 'asc')->get();

        // Map data to report format
        $peserta = $applications->map(function ($app, $i) {
            $user = $app->user;
            return [
                'no' => $i + 1,
                'nama' => $user->name ?? '-',
                'universitas' => $user->university ?? '-',
                'jurusan' => $user->major ?? '-',
                'nim' => $user->nim ?? '-',
                'tanggal_mulai' => $app->start_date ? Carbon::parse($app->start_date)->format('d-m-Y') : '-',
                'tanggal_berakhir' => $app->end_date ? Carbon::parse($app->end_date)->format('d-m-Y') : '-',
                'divisi' => $app->divisionAdmin->division_name ?? '-',
            ];
        })->toArray();

        return ['data' => $peserta];
    }

    /**
     * Calculate date range from period filter.
     */
    public function calculateDateRange(?string $period, ?int $year, ?int $month, ?string $week): array
    {
        $now = now();

        if ($period === 'mingguan' && $week) {
            $start = Carbon::parse($week);
            $end = (clone $start)->addDays(6);
        } elseif ($period === 'bulanan' && $year && $month) {
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = Carbon::create($year, $month, 1)->endOfMonth();
        } elseif ($period === 'tahunan' && $year) {
            $start = Carbon::create($year, 1, 1)->startOfYear();
            $end = Carbon::create($year, 1, 1)->endOfYear();
        } else {
            // Default based on period type
            if ($period === 'mingguan') {
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
            } elseif ($period === 'bulanan') {
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
            } else {
                // Default: current month
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
            }
        }

        return ['start' => $start, 'end' => $end];
    }

    /**
     * Get available report periods (monthly data).
     */
    public function getAvailablePeriods(): array
    {
        $minDate = InternshipApplication::whereNotNull('start_date')->min('start_date');
        $maxDate = InternshipApplication::whereNotNull('start_date')->max('start_date');

        $currentYear = date('Y');
        $minYear = $minDate ? date('Y', strtotime($minDate)) : $currentYear;
        $maxYear = $maxDate ? date('Y', strtotime($maxDate)) : $currentYear;

        // Ensure current year is included
        if ($minYear > $currentYear) {
            $minYear = $currentYear;
        }
        if ($maxYear < $currentYear) {
            $maxYear = $currentYear;
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $data = [];
        for ($y = $minYear; $y <= $maxYear; $y++) {
            foreach ($months as $num => $name) {
                $data[] = [
                    'value' => sprintf('%02d', $num) . '-' . $y,
                    'label' => $name . ' ' . $y
                ];
            }
        }

        return $data;
    }

    /**
     * Get available years.
     */
    public function getAvailableYears(): array
    {
        $minDate = InternshipApplication::whereNotNull('start_date')->min('start_date');
        $maxDate = InternshipApplication::whereNotNull('start_date')->max('start_date');

        $currentYear = date('Y');
        $minYear = $minDate ? date('Y', strtotime($minDate)) : $currentYear;
        $maxYear = $maxDate ? date('Y', strtotime($maxDate)) : $currentYear;

        // Ensure current year is included
        if ($minYear > $currentYear) {
            $minYear = $currentYear;
        }
        if ($maxYear < $currentYear) {
            $maxYear = $currentYear;
        }

        $data = [];
        for ($y = $maxYear; $y >= $minYear; $y--) {
            $data[] = ['value' => $y, 'label' => (string) $y];
        }

        return $data;
    }

    /**
     * Get report data formatted for PDF export.
     */
    public function getReportDataForExport(int $year, int $month): array
    {
        $request = new Request([
            'period' => 'bulanan',
            'year' => $year,
            'month' => $month,
        ]);

        return $this->getReportData($request)['data'];
    }

    /**
     * Get summary statistics for report.
     */
    public function getReportSummary(?int $year = null, ?int $month = null): array
    {
        $query = InternshipApplication::query()
            ->whereIn('status', ['accepted', 'finished'])
            ->whereNotNull('start_date');

        if ($year && $month) {
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = Carbon::create($year, $month, 1)->endOfMonth();

            $query->where(function ($q) use ($start, $end) {
                $q->whereDate('start_date', '<=', $end->toDateString())
                    ->where(function ($sub) use ($start) {
                        $sub->whereNull('end_date')
                            ->orWhereDate('end_date', '>=', $start->toDateString());
                    });
            });
        }

        $applications = $query->with(['divisionAdmin', 'user'])->get();

        // Group by division
        $byDivision = $applications->groupBy(function ($app) {
            return $app->divisionAdmin->division_name ?? 'Tidak Ada Divisi';
        })->map(function ($group) {
            return $group->count();
        })->toArray();

        // Group by university
        $byUniversity = $applications->groupBy(function ($app) {
            return $app->user->university ?? 'Tidak Diketahui';
        })->map(function ($group) {
            return $group->count();
        })->toArray();

        return [
            'total' => $applications->count(),
            'active' => $applications->where('status', 'accepted')->count(),
            'finished' => $applications->where('status', 'finished')->count(),
            'by_division' => $byDivision,
            'by_university' => $byUniversity,
        ];
    }
}
