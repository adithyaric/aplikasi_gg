<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportRekapPorsi(Request $request)
    {
        $query = Anggaran::with('sekolah');

        // Filter by date range if provided
        if ($request->has('start_at') && $request->has('end_at')) {
            $startDate = Carbon::parse($request->start_at);
            $endDate = Carbon::parse($request->end_at);

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });
        }

        $anggarans = $query->get();
        $rekapData = [];

        foreach ($anggarans as $anggaran) {
            $currentDate = $anggaran->start_date->copy();
            $endDate = $anggaran->end_date->copy();

            while ($currentDate <= $endDate) {
                // If date filters are provided, skip dates outside the range
                if ($request->has('start_at') && $request->has('end_at')) {
                    $filterStart = Carbon::parse($request->start_at);
                    $filterEnd = Carbon::parse($request->end_at);

                    if ($currentDate->lt($filterStart) || $currentDate->gt($filterEnd)) {
                        $currentDate->addDay();
                        continue;
                    }
                }

                $rekapData[] = [
                    'tanggal' => $currentDate->format('d/m/Y'),
                    'rencana_total' => $anggaran->total_porsi,
                    'rencana_8k' => $anggaran->porsi_8k,
                    'rencana_10k' => $anggaran->porsi_10k,
                    'budget_8k' => $anggaran->budget_porsi_8k,
                    'budget_10k' => $anggaran->budget_porsi_10k,
                    'budget_operasional' => $anggaran->budget_operasional,
                    'budget_sewa' => $anggaran->budget_sewa,
                ];
                $currentDate->addDay();
            }
        }

        // Sort by date
        usort($rekapData, function ($a, $b) {
            $dateA = Carbon::createFromFormat('d/m/Y', $a['tanggal']);
            $dateB = Carbon::createFromFormat('d/m/Y', $b['tanggal']);
            return $dateA->gt($dateB) ? 1 : -1;
        });

        //* Export Excel *//
        return Excel::download(new class($rekapData) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths, \Maatwebsite\Excel\Concerns\WithStyles {
            private $rekapData;

            public function __construct($rekapData)
            {
                $this->rekapData = $rekapData;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.rekap-porsi', [
                    'rekapData' => $this->rekapData,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 15,
                    'B' => 20,
                    'C' => 15,
                    'D' => 15,
                    'E' => 15,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [];
            }
        }, 'REKAP_PORSI_' . date('Y-m-d_H-i-T') . '.xlsx');
    }
}
