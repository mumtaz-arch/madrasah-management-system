<?php

namespace App\Livewire\Admin\Finance;

use App\Models\Tagihan;
use App\Models\Santri;
use App\Models\PaymentType;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class TagihanIndex extends Component
{
    use WithPagination;
    use \Livewire\WithFileUploads;

    public string $search = '';
    public string $activeTab = 'tagihan';
    public string $filterStatus = '';
    public string $filterBulan = '';
    public string $filterTahun = '';

    // Generate Modal
    public bool $showGenerateModal = false;
    public string $generateBulan = '';
    public string $generateTahun = '';
    public ?int $generateKelasId = null;
    public ?int $generatePaymentTypeId = null;

    // Payment Confirmation Modal
    public bool $showPaymentModal = false;
    public ?Tagihan $selectedTagihan = null;
    public string $paymentMethod = 'cash';
    public $paymentProof;
    public string $paymentDate = '';
    public string $paymentNote = '';
    public $paymentNominal;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function mount()
    {
        $this->generateBulan = now()->month;
        $this->generateTahun = now()->year;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openGenerateModal()
    {
        $this->showGenerateModal = true;
    }

    public function closeGenerateModal()
    {
        $this->showGenerateModal = false;
        $this->reset(['generateBulan', 'generateTahun', 'generateKelasId', 'generatePaymentTypeId']);
        $this->generateBulan = now()->month;
        $this->generateTahun = now()->year;
    }

    public function openPaymentModal($id)
    {
        $this->selectedTagihan = Tagihan::find($id);
        if ($this->selectedTagihan) {
            $this->paymentMethod = 'cash';
            $this->paymentDate = date('Y-m-d');
            $this->paymentNominal = $this->selectedTagihan->nominal;
            $this->paymentNote = '';
            $this->paymentProof = null;
            $this->showPaymentModal = true;
        }
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->reset(['selectedTagihan', 'paymentMethod', 'paymentProof', 'paymentDate', 'paymentNote', 'paymentNominal']);
    }

    public function processPayment()
    {
        $this->validate([
            'paymentMethod' => 'required|in:cash,transfer,qris',
            'paymentDate' => 'required|date',
            'paymentNominal' => 'required|numeric|min:0',
            'paymentProof' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if (!$this->selectedTagihan) {
            return;
        }

        $proofPath = null;
        if ($this->paymentProof) {
            $proofPath = $this->paymentProof->store('payment-proofs', 'public');
        }

        $this->selectedTagihan->update([
            'status' => 'paid',
            'metode_bayar' => $this->paymentMethod,
            'bukti_bayar' => $proofPath,
            'tanggal_bayar' => $this->paymentDate,
            'nominal_bayar' => $this->paymentNominal,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'catatan_pembayaran' => $this->paymentNote,
        ]);

        $this->closePaymentModal();
        session()->flash('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function generateTagihan()
    {
        $this->validate([
            'generateBulan' => 'required|integer|min:1|max:12',
            'generateTahun' => 'required|integer|min:2020|max:2030',
            'generatePaymentTypeId' => 'required|exists:payment_types,id',
        ], [
            'generatePaymentTypeId.required' => 'Jenis pembayaran wajib dipilih',
        ]);

        $paymentType = PaymentType::find($this->generatePaymentTypeId);
        if (!$paymentType) {
            session()->flash('error', 'Jenis pembayaran tidak ditemukan.');
            return;
        }

        // Get santri to generate tagihan for
        $santriQuery = Santri::where('status', 'aktif');
        
        if ($this->generateKelasId) {
            $santriQuery->where('kelas_id', $this->generateKelasId);
        }

        $santris = $santriQuery->get();

        if ($santris->isEmpty()) {
            session()->flash('error', 'Tidak ada santri aktif yang ditemukan.');
            return;
        }

        $generated = 0;
        $skipped = 0;

        foreach ($santris as $santri) {
            // Check if tagihan already exists
            $exists = Tagihan::where('santri_id', $santri->id)
                ->where('payment_type_id', $this->generatePaymentTypeId)
                ->where('bulan', $this->generateBulan)
                ->where('tahun', $this->generateTahun)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            // Generate tagihan
            Tagihan::create([
                'santri_id' => $santri->id,
                'payment_type_id' => $this->generatePaymentTypeId,
                'bulan' => $this->generateBulan,
                'tahun' => $this->generateTahun,
                'nominal' => $paymentType->nominal ?? 0,
                'status' => 'pending',
                'jatuh_tempo' => Carbon::create($this->generateTahun, $this->generateBulan, 10),
            ]);

            $generated++;
        }

        $this->closeGenerateModal();
        
        $message = "Berhasil generate {$generated} tagihan.";
        if ($skipped > 0) {
            $message .= " ({$skipped} sudah ada sebelumnya)";
        }
        
        session()->flash('success', $message);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function printReport()
    {
        // Filter logic same as render
        $query = Tagihan::query()
            ->with(['santri', 'paymentType']);

        if ($this->activeTab === 'tagihan') {
            $query->whereIn('status', ['pending', 'overdue']);
        } else {
            $query->where('status', 'paid');
        }
        
        // Apply filters
        $query->when($this->search, function ($q) {
            $q->whereHas('santri', function ($sub) {
                $sub->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nis', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->filterBulan, fn($q) => $q->where('bulan', $this->filterBulan))
        ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun));

        $data = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan-tagihan', [
            'data' => $data,
            'tab' => $this->activeTab,
            'filters' => [
                'bulan' => $this->filterBulan,
                'tahun' => $this->filterTahun
            ]
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'laporan-'.date('Y-m-d-His').'.pdf');
    }

    public function deleteTagihan($id)
    {
        $tagihan = Tagihan::find($id);
        if ($tagihan) {
            if ($tagihan->bukti_bayar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($tagihan->bukti_bayar);
            }
            $tagihan->delete();
            session()->flash('success', 'Tagihan berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = Tagihan::query()
            ->with(['santri', 'paymentType']);
            
        // Filter by Tab
        if ($this->activeTab === 'tagihan') {
            $query->whereIn('status', ['pending', 'overdue']);
        } else {
            $query->where('status', 'paid');
        }

        $tagihans = $query->when($this->search, function ($query) {
                $query->whereHas('santri', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%');
                });
            })
            // Only use filterStatus if specifically needed, but Tabs override status majorly
            ->when($this->filterBulan, function ($query) {
                $query->where('bulan', $this->filterBulan);
            })
            ->when($this->filterTahun, function ($query) {
                $query->where('tahun', $this->filterTahun);
            })
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Tagihan::count(),
            'pending' => Tagihan::where('status', 'pending')->count(),
            'paid' => Tagihan::where('status', 'paid')->count(),
            'overdue' => Tagihan::where('status', 'overdue')->count(),
            'totalNominal' => Tagihan::sum('nominal'),
            'totalPaid' => Tagihan::where('status', 'paid')->sum('nominal'),
        ];

        $paymentTypes = PaymentType::all();
        $kelas = \App\Models\Kelas::all();

        return view('livewire.admin.finance.tagihan-index', [
            'tagihans' => $tagihans,
            'stats' => $stats,
            'paymentTypes' => $paymentTypes,
            'kelasList' => $kelas,
        ]);
    }
}
