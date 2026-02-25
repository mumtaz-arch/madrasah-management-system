<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index()
    {
        return view('admin.finance.reports');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:monthly,yearly,summary',
            'month' => 'required_if:type,monthly|nullable|date_format:Y-m',
            'year' => 'required_if:type,yearly|nullable|integer|min:2020|max:2030',
        ]);

        $type = $request->type;
        
        if ($type === 'monthly') {
            return $this->monthlyReport($request->month);
        } elseif ($type === 'yearly') {
            return $this->yearlyReport($request->year);
        } else {
            return $this->summaryReport();
        }
    }

    protected function monthlyReport(string $month)
    {
        $date = Carbon::parse($month . '-01');
        
        $payments = Payment::whereYear('tanggal_bayar', $date->year)
            ->whereMonth('tanggal_bayar', $date->month)
            ->with(['tagihan.santri', 'tagihan.paymentType'])
            ->get();

        $totalPemasukan = $payments->sum('nominal');
        
        $byType = $payments->groupBy(fn($p) => $p->tagihan->paymentType->nama ?? 'Lainnya')
            ->map(fn($group) => $group->sum('nominal'));

        $data = [
            'title' => 'Laporan Keuangan Bulanan',
            'periode' => $date->translatedFormat('F Y'),
            'payments' => $payments,
            'totalPemasukan' => $totalPemasukan,
            'byType' => $byType,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('admin.finance.report-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download("laporan-keuangan-{$month}.pdf");
    }

    protected function yearlyReport(int $year)
    {
        $monthlyData = collect();
        
        for ($m = 1; $m <= 12; $m++) {
            $payments = Payment::whereYear('tanggal_bayar', $year)
                ->whereMonth('tanggal_bayar', $m)
                ->get();
            
            $monthlyData->push([
                'month' => Carbon::create($year, $m, 1)->translatedFormat('F'),
                'total' => $payments->sum('nominal'),
                'count' => $payments->count(),
            ]);
        }

        $totalPemasukan = $monthlyData->sum('total');

        $data = [
            'title' => 'Laporan Keuangan Tahunan',
            'periode' => $year,
            'monthlyData' => $monthlyData,
            'totalPemasukan' => $totalPemasukan,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('admin.finance.report-yearly-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download("laporan-keuangan-tahunan-{$year}.pdf");
    }

    protected function summaryReport()
    {
        $totalTagihan = Tagihan::sum('nominal');
        $totalTerbayar = Payment::sum('nominal');
        $totalTunggakan = $totalTagihan - $totalTerbayar;

        $tagihanByStatus = Tagihan::selectRaw('status, COUNT(*) as count, SUM(nominal) as total')
            ->groupBy('status')
            ->get();

        $recentPayments = Payment::with(['tagihan.santri', 'tagihan.paymentType'])
            ->latest('tanggal_bayar')
            ->limit(20)
            ->get();

        $data = [
            'title' => 'Ringkasan Keuangan',
            'totalTagihan' => $totalTagihan,
            'totalTerbayar' => $totalTerbayar,
            'totalTunggakan' => $totalTunggakan,
            'tagihanByStatus' => $tagihanByStatus,
            'recentPayments' => $recentPayments,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('admin.finance.report-summary-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download("ringkasan-keuangan.pdf");
    }

    public function invoice(Tagihan $tagihan)
    {
        $tagihan->load(['santri.kelas', 'paymentType']);
        
        $data = [
            'tagihan' => $tagihan,
            'invoiceNumber' => 'INV-' . str_pad($tagihan->id, 6, '0', STR_PAD_LEFT),
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('admin.finance.invoice-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->stream("invoice-{$data['invoiceNumber']}.pdf");
    }

    public function kwitansi(Tagihan $tagihan)
    {
        if ($tagihan->status !== 'paid') {
            return back()->with('error', 'Tagihan belum dibayar');
        }

        $tagihan->load(['santri.kelas', 'paymentType']);
        
        $data = [
            'tagihan' => $tagihan,
            'receiptNumber' => 'KWT-' . str_pad($tagihan->id, 6, '0', STR_PAD_LEFT),
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('admin.finance.kwitansi-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->stream("kwitansi-{$data['receiptNumber']}.pdf");
    }
}
