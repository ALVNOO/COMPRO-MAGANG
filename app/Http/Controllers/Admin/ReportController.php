<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ReportExport;
use App\Services\Report\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
        return view('admin.reports');
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
}
