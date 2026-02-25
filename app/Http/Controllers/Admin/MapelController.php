<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MapelExport;
use App\Imports\MapelImport;

class MapelController extends Controller
{
    public function export()
    {
        return Excel::download(new MapelExport, 'mapel-'.date('Y-m-d').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new MapelImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data mapel berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        // Simple CSV template logic or create strict Excel
        // For simplicity, we create a CSV string
        $headers = ['Kode', 'Nama', 'Kategori', 'KKM'];
        $example = ['MP001', 'Matematika', 'umum', '75'];

        $callback = function() use ($headers, $example) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fputcsv($file, $example);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=template-mapel.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }
}
