<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\DivisiAdmin;
use App\Services\Report\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * Display report page.
     */
    public function index()
    {
        $divisions = DivisiAdmin::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('division_name')
            ->get(['id', 'division_name']);

        return view('admin.reports', compact('divisions'));
    }

    /**
     * Get report data (JSON response).
     */
    public function getData(Request $request)
    {
        $data = $this->reportService->getReportData($request);

        return response()->json($data);
    }

    /**
     * Get available periods for dropdown.
     */
    public function getPeriods()
    {
        $data = $this->reportService->getAvailablePeriods();

        return response()->json(['data' => $data]);
    }

    /**
     * Get available years for dropdown.
     */
    public function getYears()
    {
        $data = $this->reportService->getAvailableYears();

        return response()->json(['data' => $data]);
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(Request $request)
    {
        $data = $this->reportService->getReportDataForExport(
            $request->input('period'),
            $request->input('year'),
            $request->input('month')
        );

        $pdf = Pdf::loadView('admin.report_pdf', ['data' => $data])
            ->setPaper('a4', 'landscape');

        return $pdf->download('report_peserta_magang.pdf');
    }

    /**
     * Export report to Excel.
     */
    public function exportExcel(Request $request)
    {
        $data = $this->reportService->getReportDataForExport(
            $request->input('period'),
            $request->input('year'),
            $request->input('month')
        );

        $export = new ReportExport($data);

        return Excel::download($export, 'report_peserta_magang.xlsx');
    }

    /**
     * Get report summary statistics.
     */
    public function getSummary(Request $request)
    {
        $summary = $this->reportService->getReportSummary(
            $request->input('year'),
            $request->input('month')
        );

        return response()->json($summary);
    }

    /**
     * Store manual report participant data.
     */
    public function storeManualEntry(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'universitas' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:100'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_berakhir' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'divisi' => ['required', 'string', 'max:255'],
            'judul_proyek' => ['nullable', 'string', 'max:255'],
            'nilai' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $entry = $this->reportService->createManualEntry($validated, (int) Auth::id());

        return response()->json([
            'message' => 'Data peserta manual berhasil ditambahkan.',
            'data' => $entry,
        ], 201);
    }
}
