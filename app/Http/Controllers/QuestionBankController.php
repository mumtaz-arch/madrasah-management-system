<?php

namespace App\Http\Controllers;

use App\Exports\QuestionsExport;
use App\Exports\QuestionsTemplateExport;
use App\Imports\QuestionsImport;
use App\Models\Guru;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuestionBankController extends Controller
{
    public function export(Request $request)
    {
        $mapelId = $request->get('mapel_id');
        $filename = 'soal_bank_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new QuestionsExport($mapelId), $filename);
    }

    public function downloadTemplate()
    {
        return Excel::download(new QuestionsTemplateExport(), 'template_soal.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'mapel_id' => 'required|exists:mapels,id',
        ]);

        $guru = Guru::where('user_id', auth()->id())->first();
        
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        try {
            Excel::import(
                new QuestionsImport($guru->id, $request->mapel_id),
                $request->file('file')
            );

            return back()->with('success', 'Soal berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
