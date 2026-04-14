<?php

namespace App\Services\Report;

use App\Models\InternshipApplication;
use App\Models\ReportManualEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
            ->with(['user.certificates', 'divisionAdmin', 'user.assignments']);

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
        $manualEntries = ReportManualEntry::query()
            ->whereDate('tanggal_mulai', '<=', $dateRange['end']->toDateString())
            ->where(function ($query) use ($dateRange) {
                $query->whereNull('tanggal_berakhir')
                    ->orWhereDate('tanggal_berakhir', '>=', $dateRange['start']->toDateString());
            })
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Map data to report format
        $appRows = $applications->map(function ($app) {
            $user = $app->user;
            $assignments = $user?->assignments ?? collect();
            [$judulProyek, $nilai] = $this->judulProyekDanRataNilai($assignments);

            return [
                'nama' => $user->name ?? '-',
                'universitas' => $user->university ?? '-',
                'jurusan' => $user->major ?? '-',
                'nim' => $user->nim ?? '-',
                'tanggal_mulai' => $app->start_date ? Carbon::parse($app->start_date)->format('d-m-Y') : '-',
                'tanggal_berakhir' => $app->end_date ? Carbon::parse($app->end_date)->format('d-m-Y') : '-',
                'divisi' => $app->divisionAdmin->division_name ?? '-',
                'judul_proyek' => $judulProyek,
                'nilai' => $nilai,
                '__sort_date' => $app->start_date,
            ];
        });

        $manualRows = $manualEntries->map(function ($entry) {
            return [
                'nama' => $entry->nama ?? '-',
                'universitas' => $entry->universitas ?? '-',
                'jurusan' => $entry->jurusan ?? '-',
                'nim' => $entry->nim ?? '-',
                'tanggal_mulai' => $entry->tanggal_mulai ? Carbon::parse($entry->tanggal_mulai)->format('d-m-Y') : '-',
                'tanggal_berakhir' => $entry->tanggal_berakhir ? Carbon::parse($entry->tanggal_berakhir)->format('d-m-Y') : '-',
                'divisi' => $entry->divisi ?? '-',
                'judul_proyek' => $entry->judul_proyek ?: '-',
                'nilai' => $entry->nilai !== null ? (string) round((float) $entry->nilai, 1) : '-',
                '__sort_date' => $entry->tanggal_mulai,
            ];
        });

        $peserta = $appRows
            ->concat($manualRows)
            ->sortBy('__sort_date')
            ->values()
            ->map(function (array $row, int $index) {
                $row['no'] = $index + 1;
                unset($row['__sort_date']);

                return $row;
            })
            ->all();

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
        } elseif ($period === 'bulanan' && $year && ! $month) {
            // Support "Semua Bulan" for a selected year
            $start = Carbon::create($year, 1, 1)->startOfYear();
            $end = Carbon::create($year, 1, 1)->endOfYear();
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
        $applicationMinDate = InternshipApplication::whereNotNull('start_date')->min('start_date');
        $applicationMaxDate = InternshipApplication::whereNotNull('start_date')->max('start_date');
        $manualMinDate = ReportManualEntry::min('tanggal_mulai');
        $manualMaxDate = ReportManualEntry::max('tanggal_mulai');

        $minDate = $this->minDateValue($applicationMinDate, $manualMinDate);
        $maxDate = $this->maxDateValue($applicationMaxDate, $manualMaxDate);

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
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $data = [];
        for ($y = $minYear; $y <= $maxYear; $y++) {
            foreach ($months as $num => $name) {
                $data[] = [
                    'value' => sprintf('%02d', $num).'-'.$y,
                    'label' => $name.' '.$y,
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
        $applicationMinDate = InternshipApplication::whereNotNull('start_date')->min('start_date');
        $applicationMaxDate = InternshipApplication::whereNotNull('start_date')->max('start_date');
        $manualMinDate = ReportManualEntry::min('tanggal_mulai');
        $manualMaxDate = ReportManualEntry::max('tanggal_mulai');

        $minDate = $this->minDateValue($applicationMinDate, $manualMinDate);
        $maxDate = $this->maxDateValue($applicationMaxDate, $manualMaxDate);

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
     * Save manual report participant entry.
     */
    public function createManualEntry(array $data, int $adminUserId): ReportManualEntry
    {
        return ReportManualEntry::create([
            'nama' => $data['nama'],
            'universitas' => $data['universitas'],
            'jurusan' => $data['jurusan'],
            'nim' => $data['nim'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'] ?? null,
            'divisi' => $data['divisi'],
            'judul_proyek' => $data['judul_proyek'] ?? null,
            'nilai' => $data['nilai'] ?? null,
            'created_by' => $adminUserId,
        ]);
    }

    /**
     * Judul tugas proyek (hanya assignment_type = tugas_proyek) dan rata-rata nilai
     * sama seperti di dashboard/assignments: avg(grade) untuk semua tugas yang punya nilai.
     *
     * @return array{0: string, 1: string}
     */
    protected function judulProyekDanRataNilai(Collection $assignments): array
    {
        $projectAssignments = $assignments->where('assignment_type', 'tugas_proyek');

        $titles = $projectAssignments->map(function ($a) {
            $t = trim((string) ($a->title ?? ''));
            if ($t !== '') {
                return $t;
            }
            $desc = $a->description ?? '';

            return $desc !== '' ? Str::limit($desc, 80) : null;
        })->filter()->values();

        $judulProyek = $titles->isEmpty() ? '-' : $titles->implode(' | ');

        $graded = $assignments->whereNotNull('grade');
        $nilai = $graded->isEmpty()
            ? '-'
            : (string) round($graded->avg('grade'), 1);

        return [$judulProyek, $nilai];
    }

    /**
     * Get report data formatted for PDF export.
     */
    public function getReportDataForExport(?string $period = null, ?int $year = null, ?int $month = null): array
    {
        $normalizedPeriod = in_array($period, ['mingguan', 'bulanan', 'tahunan'], true)
            ? $period
            : 'bulanan';
        $year = $year ?? (int) now()->year;
        $month = $month !== null ? max(1, min(12, $month)) : null;

        if ($normalizedPeriod === 'bulanan' && $month === null) {
            $month = (int) now()->month;
        }

        $request = new Request([
            'period' => $normalizedPeriod,
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

    protected function minDateValue(?string $first, ?string $second): ?string
    {
        if (! $first) {
            return $second;
        }
        if (! $second) {
            return $first;
        }

        return strtotime($first) <= strtotime($second) ? $first : $second;
    }

    protected function maxDateValue(?string $first, ?string $second): ?string
    {
        if (! $first) {
            return $second;
        }
        if (! $second) {
            return $first;
        }

        return strtotime($first) >= strtotime($second) ? $first : $second;
    }
}
