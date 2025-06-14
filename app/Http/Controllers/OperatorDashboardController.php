<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanTAT;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Tersangka;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DataTersangka;

use App\Models\LaporanTAT as LaporanTATModel;

class OperatorDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk Operator Kepolisian.
     */
    public function index()
    {
        // Mengambil semua laporan TAT yang pernah dilaporkan oleh Operator saat ini

        $laporanTAT = LaporanTAT::where('user_id', auth()->id())->paginate(10);
        dump(auth()->id());
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
    
        // Validasi request
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kronologis' => 'required|string|min:10',
            'tanggal_pelaksanaan' => 'nullable|date',
            
            // Validasi tersangka
            'tersangka' => 'required|array|min:1',
            'tersangka.*.nama' => 'required|string|max:255',
            'tersangka.*.no_ktp' => 'required|string|size:16|regex:/^[0-9]+$/',
            'tersangka.*.jenis_kelamin' => 'required|in:L,P',
            'tersangka.*.tanggal_lahir' => 'required|date|before:today',
            'tersangka.*.alamat' => 'required|string',
            'tersangka.*.foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Validasi file dokumen
            'surat_permohonan_tat' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'surat_perintah_penangkapan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'laporan_polisi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_perintah_penyidikan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_uji_laboratorium' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'berita_acara_pemeriksaan_tersangka' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_persetujuan_tat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_pernyataan_penyidik' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_surat_penerimaan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            // Custom error messages
            'tersangka.required' => 'Minimal harus ada 1 tersangka.',
            'tersangka.*.nama.required' => 'Nama tersangka harus diisi.',
            'tersangka.*.no_ktp.required' => 'No. KTP tersangka harus diisi.',
            'tersangka.*.no_ktp.size' => 'No. KTP harus 16 digit.',
            'tersangka.*.no_ktp.regex' => 'No. KTP hanya boleh berisi angka.',
            'tersangka.*.jenis_kelamin.required' => 'Jenis kelamin tersangka harus dipilih.',
            'tersangka.*.tanggal_lahir.required' => 'Tanggal lahir tersangka harus diisi.',
            'tersangka.*.tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'tersangka.*.alamat.required' => 'Alamat tersangka harus diisi.',
            'tersangka.*.foto_ktp.image' => 'Foto KTP harus berupa gambar.',
            'tersangka.*.foto_ktp.mimes' => 'Foto KTP harus format: jpeg, png, jpg, gif.',
            'tersangka.*.foto_ktp.max' => 'Ukuran foto KTP maksimal 2MB.',
            'surat_permohonan_tat.required' => 'Surat Permohonan TAT wajib diupload.',
            '*.file' => 'File yang diupload tidak valid.',
            '*.mimes' => 'File harus format: PDF, DOC, atau DOCX.',
            '*.max' => 'Ukuran file maksimal 2MB.',
            'kronologis.required' => 'Kronologis kejadian harus diisi.',
            'kronologis.min' => 'Kronologis minimal 10 karakter.',
        ]);
        
        try {
            DB::beginTransaction();

            // Array untuk menyimpan ID tersangka
            $tersangkaIds = [];

            // 1. Simpan data tersangka
            foreach ($validatedData['tersangka'] as $index => $tersangkaData) {
                // Handle upload foto KTP jika ada
                $fotoKtpPath = null;
                if ($request->hasFile("tersangka.{$index}.foto_ktp")) {
                    $fotoKtpFile = $request->file("tersangka.{$index}.foto_ktp");
                    $fotoKtpPath = $fotoKtpFile->store('tersangka/ktp', 'public');
                }

                // Simpan data tersangka
                $tersangka = Tersangka::create([
                    'nama' => $tersangkaData['nama'],
                    'no_ktp' => $tersangkaData['no_ktp'],
                    'jenis_kelamin' => $tersangkaData['jenis_kelamin'],
                    'tanggal_lahir' => $tersangkaData['tanggal_lahir'],
                    'alamat' => $tersangkaData['alamat'],
                    'foto_ktp' => $fotoKtpPath,
                ]);

                $tersangkaIds[] = $tersangka->id;
            }

            // 2. Handle file uploads untuk dokumen
            $documentPaths = [];
            $documentFields = [
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

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $file->store('laporan-tat/dokumen', 'public');
                    $documentPaths[$field] = $path;
                }
            }

            // 3. Generate nomor surat otomatis
            $nomorSurat = $this->generateNomorSurat();

            // 4. Simpan laporan TAT
            $laporanTat = LaporanTAT::create([
                'user_id' => $validatedData['user_id'],
                'nomor_surat_permohonan_tat' => $nomorSurat,
                'kronologis' => $validatedData['kronologis'],
                'data_tersangka_id' => json_encode($tersangkaIds), // Simpan array ID tersangka
                'tanggal_pelaksanaan' => $validatedData['tanggal_pelaksanaan'],
                'status' => 'pending', // Status default
                'surat_permohonan_tat' => $documentPaths['surat_permohonan_tat'] ?? null,
                'surat_perintah_penangkapan' => $documentPaths['surat_perintah_penangkapan'] ?? null,
                'laporan_polisi' => $documentPaths['laporan_polisi'] ?? null,
                'surat_perintah_penyidikan' => $documentPaths['surat_perintah_penyidikan'] ?? null,
                'surat_uji_laboratorium' => $documentPaths['surat_uji_laboratorium'] ?? null,
                'berita_acara_pemeriksaan_tersangka' => $documentPaths['berita_acara_pemeriksaan_tersangka'] ?? null,
                'surat_persetujuan_tat' => $documentPaths['surat_persetujuan_tat'] ?? null,
                'surat_pernyataan_penyidik' => $documentPaths['surat_pernyataan_penyidik'] ?? null,
                'file_surat_penerimaan' => $documentPaths['file_surat_penerimaan'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('operator.laporan.create')
                ->with('success', 'Laporan TAT berhasil disimpan dengan nomor: ' . $nomorSurat);

        } catch (\Exception $e) {
            DB::rollback();

            // Hapus file yang sudah terupload jika terjadi error
            foreach ($documentPaths ?? [] as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
        }
    }
}
