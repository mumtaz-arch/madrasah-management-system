<?php

namespace App\Http\Controllers;

use App\Exports\GuruExport;
use App\Exports\GuruTemplateExport;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function export()
    {
        $filename = 'data_guru_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new GuruExport(), $filename);
    }

    public function downloadTemplate()
    {
        return Excel::download(new GuruTemplateExport(), 'template_guru.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new GuruImport(), $request->file('file'));
            return back()->with('success', 'Data guru berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
