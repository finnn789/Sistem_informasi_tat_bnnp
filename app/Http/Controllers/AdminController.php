<?php
namespace App\Http\Controllers;

use App\Models\LaporanTAT;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $laporan = LaporanTAT::where('status', 'menunggu')->get();
        return view('admin.dashboard', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = LaporanTAT::findOrFail($id);
        return view('admin.laporan-detail', compact('laporan'));
    }

    public function terima(Request $request, $id)
    {
        $laporan = LaporanTAT::findOrFail($id);
        $laporan->status = 'diterima';
        $laporan->tanggal_pelaksanaan = $request->tanggal_pelaksanaan;
        if ($request->hasFile('file_surat_penerimaan')) {
            $laporan->file_surat_penerimaan = $request->file('file_surat_penerimaan')->store('surat_penerimaan');
        }
        $laporan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Berkas diterima.');
    }

    public function tolak(Request $request, $id)
    {
        $laporan = LaporanTAT::findOrFail($id);
        $laporan->status = 'ditolak';
        $laporan->alasan_penolakan = $request->alasan_penolakan;
        $laporan->save();

        return redirect()->route('admin.dashboard')->with('error', 'Berkas ditolak.');
    }
}
