<?php

namespace App\Livewire\Wali;

use App\Models\Santri;
use App\Models\Tagihan;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TagihanAnak extends Component
{
    public ?int $selectedSantriId = null;
    public string $filterStatus = '';

    public function mount()
    {
        // Auto-select first santri
        $wali = Auth::user()->wali;
        if ($wali) {
            $firstSantri = Santri::where('wali_id', $wali->id)->first();
            if ($firstSantri) {
                $this->selectedSantriId = $firstSantri->id;
            }
        }
    }

    public function render()
    {
        $wali = Auth::user()->wali;
        $santris = collect();
        $tagihans = collect();
        $selectedSantri = null;
        $stats = [
            'total_tagihan' => 0,
            'total_lunas' => 0,
            'total_pending' => 0,
            'total_overdue' => 0,
        ];

        if ($wali) {
            $santris = Santri::where('wali_id', $wali->id)->get();

            if ($this->selectedSantriId) {
                $selectedSantri = Santri::with('kelas')->find($this->selectedSantriId);
                
                $query = Tagihan::with('paymentType')
                    ->where('santri_id', $this->selectedSantriId)
                    ->orderBy('jatuh_tempo', 'desc');

                if ($this->filterStatus) {
                    $query->where('status', $this->filterStatus);
                }

                $tagihans = $query->get();

                // Calculate stats
                $allTagihans = Tagihan::where('santri_id', $this->selectedSantriId)->get();
                $stats['total_tagihan'] = $allTagihans->sum('jumlah');
                $stats['total_lunas'] = $allTagihans->where('status', 'paid')->sum('jumlah');
                $stats['total_pending'] = $allTagihans->where('status', 'pending')->sum('jumlah');
                $stats['total_overdue'] = $allTagihans->where('status', 'overdue')->sum('jumlah');
            }
        }

        return view('livewire.wali.tagihan-anak', [
            'santris' => $santris,
            'selectedSantri' => $selectedSantri,
            'tagihans' => $tagihans,
            'stats' => $stats,
        ]);
    }
}
