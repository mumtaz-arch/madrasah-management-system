<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherJournalRequest;
use App\Http\Requests\UpdateTeacherJournalRequest;
use App\Models\TeacherJournal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ensure user is a guru
        if (!$user->isGuru()) {
            abort(403, 'Unauthorized action.');
        }
        
        $query = TeacherJournal::where('teacher_id', $user->guru->id)
            ->with(['classroom', 'subject'])
            ->latest('date');
            
        // Filters
        if ($request->filled('month')) {
            $query->whereMonth('date', date('m', strtotime($request->month)))
                  ->whereYear('date', date('Y', strtotime($request->month)));
        }
        
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        
        $journals = $query->paginate(10);
        $kelas = Kelas::all();
        
        // Widget Data
        $todayJournalCount = TeacherJournal::where('teacher_id', $user->guru->id)
            ->whereDate('date', today())
            ->count();
            
        return view('guru.journal.index', compact('journals', 'kelas', 'todayJournalCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TeacherJournal::class);
        
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        
        return view('guru.journal.create', compact('kelas', 'mapels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherJournalRequest $request)
    {
        $this->authorize('create', TeacherJournal::class);
        
        $data = $request->validated();
        $data['teacher_id'] = Auth::user()->guru->id;
        
        TeacherJournal::create($data);
        
        return redirect()->route('guru.journal.index')
            ->with('success', 'Jurnal berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherJournal $teacherJournal)
    {
        $this->authorize('update', $teacherJournal);
        
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        
        return view('guru.journal.edit', compact('teacherJournal', 'kelas', 'mapels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherJournalRequest $request, TeacherJournal $teacherJournal)
    {
        $this->authorize('update', $teacherJournal);
        
        $teacherJournal->update($request->validated());
        
        return redirect()->route('guru.journal.index')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherJournal $teacherJournal)
    {
        $this->authorize('delete', $teacherJournal);
        
        $teacherJournal->delete();
        
        return redirect()->route('guru.journal.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
