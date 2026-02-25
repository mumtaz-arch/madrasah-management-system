<?php

namespace App\Http\Controllers;

use App\Exports\SantriExport;
use App\Exports\SantriTemplateExport;
use App\Imports\SantriImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SantriController extends Controller
{
    public function export(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $filename = 'data_santri_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new SantriExport($kelasId), $filename);
    }

    public function downloadTemplate()
    {
        return Excel::download(new SantriTemplateExport(), 'template_santri.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new SantriImport(), $request->file('file'));
            return back()->with('success', 'Data santri berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
