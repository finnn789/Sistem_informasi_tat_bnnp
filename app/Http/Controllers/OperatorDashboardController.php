<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanTAT;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
}
