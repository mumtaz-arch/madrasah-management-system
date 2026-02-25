<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogs extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterAction = '';
    public string $filterDate = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ActivityLog::with('user')
            ->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->filterAction) {
            $query->where('action', $this->filterAction);
        }

        if ($this->filterDate) {
            $query->whereDate('created_at', $this->filterDate);
        }

        $logs = $query->paginate(20);

        $actions = ActivityLog::distinct()->pluck('action');

        return view('livewire.admin.activity-logs', [
            'logs' => $logs,
            'actions' => $actions,
        ]);
    }
}
