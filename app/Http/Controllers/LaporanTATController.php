<?php

namespace App\Http\Controllers;

use App\Models\LaporanTAT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanTATController extends Controller
{
    public function index()
    {
        $laporan = LaporanTAT::where('user_id', Auth::id())->get();
        return view('operator.dashboard', compact('laporan'));
    }

    public function create()
    {
        return view('operator.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_permohonan_tat' => 'required|file|mimes:pdf,docx,doc|max:10240',
            'surat_perintah_penangkapan' => 'required|file|mimes:pdf,docx,doc|max:10240',
            // validasi file lainnya
        ]);

        $laporan = new LaporanTAT([
            'user_id' => Auth::id(),
            'surat_permohonan_tat' => $request->file('surat_permohonan_tat')->store('laporan_tat'),
            'surat_perintah_penangkapan' => $request->file('surat_perintah_penangkapan')->store('laporan_tat'),
            'kronologis' => $request->kronologis,
            'status' => 'menunggu',
        ]);

        $laporan->save();

        return redirect()->route('operator.dashboard')->with('success', 'Berkas berhasil dikirim.');
    }

    public function laporanDisetujui()
    {
        $laporanTAT = LaporanTAT::where('user_id', auth()->id())->paginate(10);

        // $dataUser = auth()->user();
        $user = Auth::user();
        $nama = $user->name;

        $satker = $user->satuan_kerja;

        $totalLaporan = LaporanTAT::where('user_id', auth()->id())->count(); // Total laporan (tanpa pagination)
        $totalDiterima = LaporanTAT::where('user_id', auth()->id())->where('status', 'diterima')->count();

        return view('operator.dashboard', compact(
            'laporanTAT',
            'nama',
            'satker',
            'totalLaporan',
            'totalDiterima',
            'totalDitolak',
            'totalProses'
        ));
    }
}
