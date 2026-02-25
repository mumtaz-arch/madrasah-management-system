<?php

namespace App\Livewire\Admin\Ppdb;

use App\Models\PpdbRegistration;
use App\Mail\PpdbVerificationMail;
use App\Mail\PpdbAcceptanceMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class PpdbIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updateStatus(int $id, string $status)
    {
        $registration = PpdbRegistration::find($id);
        if ($registration) {
            $registration->update(['status' => $status]);
            session()->flash('success', 'Status pendaftaran berhasil diperbarui.');
        }
    }

    public function verifyAndEmail(int $id)
    {
        $registration = PpdbRegistration::find($id);
        if ($registration) {
            $registration->update(['status' => 'verifikasi']);
            
            // Send verification email
            if ($registration->email) {
                try {
                    Mail::to($registration->email)->send(new PpdbVerificationMail($registration));
                    session()->flash('success', 'Pendaftaran berhasil diverifikasi dan email notifikasi telah dikirim.');
                } catch (\Exception $e) {
                    session()->flash('success', 'Pendaftaran berhasil diverifikasi. (Email gagal terkirim: ' . $e->getMessage() . ')');
                }
            } else {
                session()->flash('success', 'Pendaftaran berhasil diverifikasi. (Email tidak tersedia)');
            }
        }
    }

    public function acceptAndEmail(int $id)
    {
        $registration = PpdbRegistration::find($id);
        if ($registration) {
            $registration->update(['status' => 'diterima']);
            
            // Send acceptance email
            if ($registration->email) {
                try {
                    Mail::to($registration->email)->send(new PpdbAcceptanceMail($registration));
                    session()->flash('success', 'Pendaftaran berhasil diterima dan email notifikasi telah dikirim.');
                } catch (\Exception $e) {
                    session()->flash('success', 'Pendaftaran berhasil diterima. (Email gagal terkirim: ' . $e->getMessage() . ')');
                }
            } else {
                session()->flash('success', 'Pendaftaran berhasil diterima. (Email tidak tersedia)');
            }
        }
    }

    public function render()
    {
        $registrations = PpdbRegistration::query()
            ->with('documents')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('no_pendaftaran', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('no_hp_wali', 'like', '%' . $this->search . '%')
                      ->orWhere('no_hp', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::where('status', 'pending')->count(),
            'verifikasi' => PpdbRegistration::where('status', 'verifikasi')->count(),
            'diterima' => PpdbRegistration::where('status', 'diterima')->count(),
            'ditolak' => PpdbRegistration::where('status', 'ditolak')->count(),
        ];

        return view('livewire.admin.ppdb.ppdb-index', [
            'registrations' => $registrations,
            'stats' => $stats,
        ]);
    }
}
