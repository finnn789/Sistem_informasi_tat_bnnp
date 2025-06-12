<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanTAT;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Tersangka;

class OperatorDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk Operator Kepolisian.
     */
    public function index()
    {
        // Mengambil semua laporan TAT yang pernah dilaporkan oleh Operator saat ini

        $laporanTAT = LaporanTAT::where('user_id', auth()->id())->paginate(10);

        // $dataUser = auth()->user();
        $user = Auth::user();
        $nama = $user->name;

        $satker = $user->satuan_kerja;

        $totalLaporan = LaporanTAT::where('user_id', auth()->id())->count(); // Total laporan (tanpa pagination)
        $totalDiterima = LaporanTAT::where('user_id', auth()->id())->where('status', 'diterima')->count();
        $totalDitolak = LaporanTAT::where('user_id', auth()->id())->where('status', 'ditolak')->count();
        $totalProses = LaporanTAT::where('user_id', auth()->id())->where('status', 'menunggu')->count();

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

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create()
    {
        return view('operator.create-laporan');
    }

    public function store(Request $request)
    {

        // Validasi data yang diterima
        // $validator = Validator::make($request->all(), [
        //     'user_id' => 'required|integer',
        //     'surat_permohonan_tat' => 'required|string',
        //     'surat_perintah_penangkapan' => 'required|string',
        //     'kronologis' => 'required|string',
        //     'data_tersangka_id' => 'required|integer',
        //     'laporan_polisi' => 'required|string',
        //     'surat_perintah_penyidikan' => 'required|string',
        //     'surat_uji_laboratorium' => 'required|string',
        //     'berita_acara_pemeriksaan_tersangka' => 'required|string',
        //     'surat_persetujuan_tat' => 'required|string',
        //     'surat_pernyataan_penyidik' => 'required|string',
        //     'status' => 'required|string',
        //     'alasan_penolakan' => 'nullable|string',
        //     'tanggal_pelaksanaan' => 'required|date',
        //     'file_surat_penerimaan' => 'required|string',
        //     'data_tersangka' => 'required|array',
        //     'data_tersangka.*.nama' => 'required|string',
        //     'data_tersangka.*.umur' => 'required|integer'
        // ]);
        dump($request->all());

        // Jika validasi gagal, kembalikan error
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // Membuat laporan TAT baru
        // $laporanTAT = LaporanTAT::create([
        //     'user_id' => $request->user_id,
        //     'surat_permohonan_tat' => $request->surat_permohonan_tat,
        //     'surat_perintah_penangkapan' => $request->surat_perintah_penangkapan,
        //     'kronologis' => $request->kronologis,
        //     'data_tersangka_id' => $request->data_tersangka_id,
        //     'laporan_polisi' => $request->laporan_polisi,
        //     'surat_perintah_penyidikan' => $request->surat_perintah_penyidikan,
        //     'surat_uji_laboratorium' => $request->surat_uji_laboratorium,
        //     'berita_acara_pemeriksaan_tersangka' => $request->berita_acara_pemeriksaan_tersangka,
        //     'surat_persetujuan_tat' => $request->surat_persetujuan_tat,
        //     'surat_pernyataan_penyidik' => $request->surat_pernyataan_penyidik,
        //     'status' => $request->status,
        //     'alasan_penolakan' => $request->alasan_penolakan,
        //     'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
        //     'file_surat_penerimaan' => $request->file_surat_penerimaan,
        // ]);

        // Menyimpan data tersangka terkait
        // foreach ($request->data_tersangka as $tersangkaData) {
        //     $laporanTAT->tersangka()->create([
        //         'nama' => $tersangkaData['nama'],
        //         'umur' => $tersangkaData['umur'],
        //     ]);
        // }

        // Mengembalikan respon sukses
        return response()->json([
            'message' => 'Laporan TAT berhasil dibuat!',
            'laporan_tat' => $request->all()
        ], 201);
    }
}
