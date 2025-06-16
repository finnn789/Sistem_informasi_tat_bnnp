<?php
namespace App\Http\Controllers;

use App\Models\LaporanTAT;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    $total = LaporanTAT::count();
    $diterima = LaporanTAT::where('status', 'diterima')->count();
    $menunggu = LaporanTAT::where('status', 'menunggu')->count();
    $ditolak = LaporanTAT::where('status', 'ditolak')->count();

    return view('admin.dashboard', compact('total', 'diterima', 'menunggu', 'ditolak'));
}


    public function show($id)
    {
        $laporan = LaporanTAT::findOrFail($id);
        return view('admin.laporan-detail', compact('laporan'));
    }

   public function setujui($id)
{
    $laporan = LaporanTAT::findOrFail($id);
    $laporan->status = 'diterima';
    $laporan->save();

    // Hapus session preview_path
    session()->forget('preview_path');

    return redirect()->back()->with('success', 'Laporan diterima.');
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

    // Hapus session preview_path
    session()->forget('preview_path');

    return redirect()->back()->with('error', 'Laporan ditolak.');
}

    public function suratMasuk()
    {
    $laporans = LaporanTAT::latest()->get(); // ambil semua data laporan TAT
    return view('admin.suratmasuk', compact('laporans'));
    }
    public function approve($id)
{
    $laporan = LaporanTAT::findOrFail($id);
    $laporan->status = 'diterima';
    $laporan->save();

    return redirect()->back()->with('success', 'Laporan berhasil diterima.');
}

public function reject($id)
{
    $laporan = LaporanTAT::findOrFail($id);
    $laporan->status = 'ditolak';
    $laporan->save();

    return redirect()->back()->with('success', 'Laporan berhasil ditolak.');
}
public function previewDokumen($id, $field)
{
    $laporan = LaporanTAT::findOrFail($id);

    // Validasi field yang boleh ditampilkan
    $allowedFields = [
        'surat_permohonan_tat',
        'surat_perintah_penangkapan',
        'laporan_polisi',
        'surat_perintah_penyidikan',
        'surat_uji_laboratorium',
        'berita_acara_pemeriksaan_tersangka',
        'surat_persetujuan_tat',
        'surat_pernyataan_penyidik',
        'file_surat_penerimaan'
    ];

    if (!in_array($field, $allowedFields)) {
        return redirect()->back()->with('error', 'Dokumen tidak dikenali.');
    }

    if (!$laporan->$field) {
        return redirect()->back()->with('error', 'Dokumen tidak tersedia.');
    }

    // Simpan path file ke session agar bisa ditampilkan di blade
    session(['preview_path' => $laporan->$field]);

    return redirect()->route('admin.laporan.detail', $laporan->id);
}


}
