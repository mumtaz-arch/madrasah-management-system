<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherJournal;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\JournalExport;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TeacherJournal::with(['teacher', 'classroom', 'subject', 'verifier'])
            ->latest('date');

        // Filters
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $journals = $query->paginate(15);
        
        $gurus = Guru::orderBy('nama_lengkap')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mapels = Mapel::orderBy('nama')->get();

        // Widget Data
        $currentMonthCount = TeacherJournal::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        return view('admin.journal.index', compact('journals', 'gurus', 'kelas', 'mapels', 'currentMonthCount'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherJournal $journal)
    {
        $journal->load(['teacher', 'classroom', 'subject', 'verifier']);
        return view('admin.journal.show', compact('journal'));
    }

    /**
     * Verify the journal.
     */
    public function verify(TeacherJournal $journal)
    {
        $this->authorize('verify', TeacherJournal::class);

        $journal->update([
            'status' => TeacherJournal::STATUS_VERIFIED,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Jurnal berhasil diverifikasi.');
    }

    /**
     * Export usage.
     */
    public function export(Request $request)
    {
        $filters = $request->only(['teacher_id', 'class_id', 'subject_id', 'status', 'start_date', 'end_date']);

        if ($request->type === 'pdf') {
            // Applying filters manually since scope is not yet implemented in model
            $query = TeacherJournal::with(['teacher', 'classroom', 'subject', 'verifier'])->latest('date');
            if (!empty($filters['teacher_id'])) $query->where('teacher_id', $filters['teacher_id']);
            if (!empty($filters['class_id'])) $query->where('class_id', $filters['class_id']);
            if (!empty($filters['subject_id'])) $query->where('subject_id', $filters['subject_id']);
            if (!empty($filters['status'])) $query->where('status', $filters['status']);
            if (!empty($filters['start_date'])) $query->whereDate('date', '>=', $filters['start_date']);
            if (!empty($filters['end_date'])) $query->whereDate('date', '<=', $filters['end_date']);
            
            $journals = $query->get();

            $pdf = Pdf::loadView('admin.journal.pdf', compact('journals', 'filters'));
            return $pdf->download('jurnal-guru.pdf');
        }

        return Excel::download(new JournalExport($filters), 'jurnal-guru.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherJournal $journal)
    {
        $journal->delete();

        return redirect()->route('admin.journal.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
