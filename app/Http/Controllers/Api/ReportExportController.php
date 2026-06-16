<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportController extends Controller
{
    public function sickStudentsCsv(Request $request): StreamedResponse
    {
        $from = $request->date('from', now()->startOfMonth());
        $to = $request->date('to', now()->endOfMonth());
        $filename = 'laporan-santri-sakit-' . $from->toDateString() . '-' . $to->toDateString() . '.csv';

        return response()->streamDownload(function () use ($from, $to): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['NIS', 'Nama', 'Asrama', 'Tanggal Lapor', 'Gejala Utama', 'Urgensi', 'Status', 'Diagnosis']);

            HealthReport::with('student')
                ->whereBetween('reported_at', [$from, $to])
                ->orderBy('reported_at')
                ->chunk(200, function ($reports) use ($handle): void {
                    foreach ($reports as $report) {
                        fputcsv($handle, [
                            $report->student?->nis,
                            $report->student?->name,
                            $report->student?->dormitory,
                            $report->reported_at?->format('Y-m-d H:i:s'),
                            $report->main_symptom,
                            $report->urgency,
                            $report->status,
                            $report->diagnosis,
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
