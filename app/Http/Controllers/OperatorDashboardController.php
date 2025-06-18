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

    private function generateCustomFileName($file, $prefix = '')
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Ymd_His');
        $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);

        // Bersihkan nama file dari karakter khusus
        $cleanName = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $originalName);

        $customName = $prefix ?
            "{$prefix}_{$cleanName}_{$timestamp}_{$randomString}.{$extension}" :
            "{$cleanName}_{$timestamp}_{$randomString}.{$extension}";

        return $customName;
    }

    /**
     * Helper method untuk upload file dengan nama custom
     */
    private function uploadFileWithCustomName($file, $directory, $prefix = '')
    {
        $customFileName = $this->generateCustomFileName($file, $prefix);
        $path = $file->storeAs($directory, $customFileName, 'public');
        return $path;
    }

    public function store(Request $request)
    {
        // Validasi request
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kronologis' => 'required|string|min:10',
            'tanggal_pelaksanaan' => 'nullable|date',
            'nomor_surat_permohonan_tat' => 'nullable|string|max:255',

            // Validasi tersangka
            'tersangka' => 'required|array|min:1',
            'tersangka.*.nama' => 'required|string|max:255',
            'tersangka.*.no_ktp' => 'required|string|size:16|regex:/^[0-9]+$/|distinct',
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
            'tersangka.*.no_ktp.distinct' => 'No. KTP tersangka tidak boleh sama.',
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

            // 1. Simpan data tersangka menggunakan firstOrCreate untuk avoid duplikasi
            foreach ($validatedData['tersangka'] as $index => $tersangkaData) {
                // Handle upload foto KTP jika ada
                $fotoKtpPath = null;
                if ($request->hasFile("tersangka.{$index}.foto_ktp")) {
                    $fotoKtpFile = $request->file("tersangka.{$index}.foto_ktp");
                    $fotoKtpPath = $this->uploadFileWithCustomName($fotoKtpFile, 'tersangka/ktp', 'foto_ktp');
                }

                // Cari atau buat tersangka baru berdasarkan no_ktp
                $tersangka = Tersangka::firstOrCreate(
                    ['no_ktp' => $tersangkaData['no_ktp']], // Cari berdasarkan NIK
                    [
                        'nama' => $tersangkaData['nama'],
                        'jenis_kelamin' => $tersangkaData['jenis_kelamin'],
                        'tanggal_lahir' => $tersangkaData['tanggal_lahir'],
                        'alamat' => $tersangkaData['alamat'],
                        'foto_ktp' => $fotoKtpPath,
                    ]
                );

                // Jika tersangka sudah ada tapi foto KTP baru diupload, update foto
                if (!$tersangka->wasRecentlyCreated && $fotoKtpPath) {
                    // Hapus foto lama jika ada
                    if ($tersangka->foto_ktp && Storage::disk('public')->exists($tersangka->foto_ktp)) {
                        Storage::disk('public')->delete($tersangka->foto_ktp);
                    }
                    $tersangka->update(['foto_ktp' => $fotoKtpPath]);
                }

                $tersangkaIds[] = $tersangka->id;
            }

            // 2. Handle file uploads untuk dokumen dengan nama custom
            $documentPaths = [];
            $documentFields = [
                'surat_permohonan_tat' => 'surat_permohonan',
                'surat_perintah_penangkapan' => 'surat_penangkapan',
                'laporan_polisi' => 'laporan_polisi',
                'surat_perintah_penyidikan' => 'surat_penyidikan',
                'surat_uji_laboratorium' => 'uji_lab',
                'berita_acara_pemeriksaan_tersangka' => 'ba_pemeriksaan',
                'surat_persetujuan_tat' => 'surat_persetujuan',
                'surat_pernyataan_penyidik' => 'surat_pernyataan',
                'file_surat_penerimaan' => 'surat_penerimaan'
            ];

            foreach ($documentFields as $field => $prefix) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $this->uploadFileWithCustomName($file, 'laporan-tat/dokumen', $prefix);
                    $documentPaths[$field] = $path;
                }
            }

            // 3. Generate nomor surat otomatis
            $nomorSurat = $this->generateNomorSurat();

            // 4. Simpan laporan TAT
            $laporanTat = LaporanTAT::create([
                'user_id' => $validatedData['user_id'],
                'nomor_surat_permohonan_tat' => $validatedData['nomor_surat_permohonan_tat'] ?? $nomorSurat,
                'kronologis' => $validatedData['kronologis'],
                'tanggal_pelaksanaan' => $validatedData['tanggal_pelaksanaan'],
                'status' => 'menunggu', // Status default sesuai enum
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

            // 5. Hubungkan laporan dengan tersangka menggunakan relasi many-to-many
            $laporanTat->tersangka()->attach($tersangkaIds);

            DB::commit();

            return redirect()
                ->route('operator.laporan.create')
                ->with('success', 'Laporan TAT berhasil disimpan dengan nomor: ' . $laporanTat->nomor_surat_permohonan_tat);
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


    /**
     * Generate nomor surat otomatis
     */
    private function generateNomorSurat()
    {
        $tahun = date('Y');

        // Ambil nomor urut terakhir dari database untuk tahun ini
        $lastLaporan = LaporanTAT::whereYear('created_at', $tahun)
            ->orderBy('id', 'desc')
            ->first();

        // Tentukan nomor urut berikutnya
        if ($lastLaporan) {
            // Extract nomor dari nomor surat terakhir
            $lastNumber = $this->extractNumberFromSurat($lastLaporan->nomor_surat_permohonan_tat);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format: TAT/001/2025
        return 'TAT/' . sprintf('%03d', $nextNumber) . '/' . $tahun;
    }

    /**
     * Extract nomor urut dari nomor surat
     */
    private function extractNumberFromSurat($nomorSurat)
    {
        // Contoh: TAT/001/2025 -> ambil 001
        $parts = explode('/', $nomorSurat);
        if (count($parts) >= 2) {
            return intval($parts[1]);
        }
        return 0;
    }

    public function editlaporan($id)
    {
        // Ambil laporan berdasarkan ID
        $laporan = LaporanTAT::findOrFail($id);
        // dd($laporan);
        // Ambil semua tersangka yang terkait dengan laporan ini
        $tersangka = $laporan->tersangka;
        // dd($tersangka, $laporan);

        return view('operator.edit-laporan', compact('laporan', 'tersangka'));
    }

    public function update(Request $request, $id)
    {
        // Cari laporan yang akan diupdate
        $laporanTat = LaporanTAT::with('tersangka')->findOrFail($id);

        // Validasi request
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kronologis' => 'required|string|min:10',
            'tanggal_pelaksanaan' => 'nullable|date',
            'nomor_surat_permohonan_tat' => 'nullable|string|max:255',

            // Validasi tersangka
            'tersangka' => 'required|array|min:1',
            'tersangka.*.id' => 'nullable|exists:tersangka,id',
            'tersangka.*.nama' => 'required|string|max:255',
            'tersangka.*.no_ktp' => 'required|string|size:16|regex:/^[0-9]+$/|distinct',
            'tersangka.*.jenis_kelamin' => 'required|in:L,P',
            'tersangka.*.tanggal_lahir' => 'required|date|before:today',
            'tersangka.*.alamat' => 'required|string',
            'tersangka.*.foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tersangka.*.hapus_foto' => 'nullable|boolean',

            // Validasi file dokumen
            'surat_permohonan_tat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_perintah_penangkapan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'laporan_polisi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_perintah_penyidikan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_uji_laboratorium' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'berita_acara_pemeriksaan_tersangka' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_persetujuan_tat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'surat_pernyataan_penyidik' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_surat_penerimaan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',

            // Flag untuk hapus file lama
            'hapus_surat_permohonan_tat' => 'nullable|boolean',
            'hapus_surat_perintah_penangkapan' => 'nullable|boolean',
            'hapus_laporan_polisi' => 'nullable|boolean',
            'hapus_surat_perintah_penyidikan' => 'nullable|boolean',
            'hapus_surat_uji_laboratorium' => 'nullable|boolean',
            'hapus_berita_acara_pemeriksaan_tersangka' => 'nullable|boolean',
            'hapus_surat_persetujuan_tat' => 'nullable|boolean',
            'hapus_surat_pernyataan_penyidik' => 'nullable|boolean',
            'hapus_file_surat_penerimaan' => 'nullable|boolean',
        ], [
            // Custom error messages (sama seperti store method)
            'tersangka.required' => 'Minimal harus ada 1 tersangka.',
            'tersangka.*.nama.required' => 'Nama tersangka harus diisi.',
            'tersangka.*.no_ktp.required' => 'No. KTP tersangka harus diisi.',
            'tersangka.*.no_ktp.size' => 'No. KTP harus 16 digit.',
            'tersangka.*.no_ktp.regex' => 'No. KTP hanya boleh berisi angka.',
            'tersangka.*.no_ktp.distinct' => 'No. KTP tersangka tidak boleh sama.',
            'tersangka.*.jenis_kelamin.required' => 'Jenis kelamin tersangka harus dipilih.',
            'tersangka.*.tanggal_lahir.required' => 'Tanggal lahir tersangka harus diisi.',
            'tersangka.*.tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'tersangka.*.alamat.required' => 'Alamat tersangka harus diisi.',
            'tersangka.*.foto_ktp.image' => 'Foto KTP harus berupa gambar.',
            'tersangka.*.foto_ktp.mimes' => 'Foto KTP harus format: jpeg, png, jpg, gif.',
            'tersangka.*.foto_ktp.max' => 'Ukuran foto KTP maksimal 2MB.',
            '*.file' => 'File yang diupload tidak valid.',
            '*.mimes' => 'File harus format: PDF, DOC, atau DOCX.',
            '*.max' => 'Ukuran file maksimal 2MB.',
            'kronologis.required' => 'Kronologis kejadian harus diisi.',
            'kronologis.min' => 'Kronologis minimal 10 karakter.',
        ]);

        try {
            DB::beginTransaction();

            // Array untuk menyimpan ID tersangka baru
            $tersangkaIds = [];
            $filesToDelete = [];

            // 1. Update/Create data tersangka
            foreach ($validatedData['tersangka'] as $index => $tersangkaData) {
                $fotoKtpPath = null;
                $tersangkaId = $tersangkaData['id'] ?? null;

                // Handle upload foto KTP jika ada
                if ($request->hasFile("tersangka.{$index}.foto_ktp")) {
                    $fotoKtpFile = $request->file("tersangka.{$index}.foto_ktp");
                    $fotoKtpPath = $this->uploadFileWithCustomName($fotoKtpFile, 'tersangka/ktp', 'foto_ktp_update');
                }

                if ($tersangkaId) {
                    // Update tersangka yang sudah ada
                    $tersangka = Tersangka::findOrFail($tersangkaId);

                    // Simpan path foto lama untuk dihapus jika ada foto baru
                    if ($fotoKtpPath && $tersangka->foto_ktp) {
                        $filesToDelete[] = $tersangka->foto_ktp;
                    }

                    // Handle hapus foto lama
                    if ($request->boolean("tersangka.{$index}.hapus_foto") && $tersangka->foto_ktp) {
                        $filesToDelete[] = $tersangka->foto_ktp;
                        $fotoKtpPath = null;
                    }

                    $updateData = [
                        'nama' => $tersangkaData['nama'],
                        'no_ktp' => $tersangkaData['no_ktp'],
                        'jenis_kelamin' => $tersangkaData['jenis_kelamin'],
                        'tanggal_lahir' => $tersangkaData['tanggal_lahir'],
                        'alamat' => $tersangkaData['alamat'],
                    ];

                    if ($fotoKtpPath !== null || $request->boolean("tersangka.{$index}.hapus_foto")) {
                        $updateData['foto_ktp'] = $fotoKtpPath;
                    }

                    $tersangka->update($updateData);
                    $tersangkaIds[] = $tersangka->id;
                } else {
                    // Buat tersangka baru
                    $tersangka = Tersangka::firstOrCreate(
                        ['no_ktp' => $tersangkaData['no_ktp']],
                        [
                            'nama' => $tersangkaData['nama'],
                            'jenis_kelamin' => $tersangkaData['jenis_kelamin'],
                            'tanggal_lahir' => $tersangkaData['tanggal_lahir'],
                            'alamat' => $tersangkaData['alamat'],
                            'foto_ktp' => $fotoKtpPath,
                        ]
                    );

                    if (!$tersangka->wasRecentlyCreated && $fotoKtpPath) {
                        if ($tersangka->foto_ktp) {
                            $filesToDelete[] = $tersangka->foto_ktp;
                        }
                        $tersangka->update(['foto_ktp' => $fotoKtpPath]);
                    }

                    $tersangkaIds[] = $tersangka->id;
                }
            }

            // 2. Handle file uploads untuk dokumen dengan nama custom
            $documentPaths = [];
            $documentFields = [
                'surat_permohonan_tat' => 'surat_permohonan_update',
                'surat_perintah_penangkapan' => 'surat_penangkapan_update',
                'laporan_polisi' => 'laporan_polisi_update',
                'surat_perintah_penyidikan' => 'surat_penyidikan_update',
                'surat_uji_laboratorium' => 'uji_lab_update',
                'berita_acara_pemeriksaan_tersangka' => 'ba_pemeriksaan_update',
                'surat_persetujuan_tat' => 'surat_persetujuan_update',
                'surat_pernyataan_penyidik' => 'surat_pernyataan_update',
                'file_surat_penerimaan' => 'surat_penerimaan_update'
            ];

            foreach ($documentFields as $field => $prefix) {
                // Cek jika ada file baru
                if ($request->hasFile($field)) {
                    // Hapus file lama jika ada
                    if ($laporanTat->{$field}) {
                        $filesToDelete[] = $laporanTat->{$field};
                    }
                    // Upload file baru dengan nama custom
                    $file = $request->file($field);
                    $path = $this->uploadFileWithCustomName($file, 'laporan-tat/dokumen', $prefix);
                    $documentPaths[$field] = $path;
                }
                // Cek jika ada flag hapus file
                elseif ($request->boolean("hapus_{$field}")) {
                    if ($laporanTat->{$field}) {
                        $filesToDelete[] = $laporanTat->{$field};
                    }
                    $documentPaths[$field] = null;
                }
                // Jika tidak ada perubahan, pertahankan file lama
                else {
                    $documentPaths[$field] = $laporanTat->{$field};
                }
            }

            // 3. Update laporan TAT
            $updateLaporanData = [
                'user_id' => $validatedData['user_id'],
                'kronologis' => $validatedData['kronologis'],
                'tanggal_pelaksanaan' => $validatedData['tanggal_pelaksanaan'],
            ];

            if (isset($validatedData['nomor_surat_permohonan_tat'])) {
                $updateLaporanData['nomor_surat_permohonan_tat'] = $validatedData['nomor_surat_permohonan_tat'];
            }

            // Update paths dokumen
            foreach (array_keys($documentFields) as $field) {
                $updateLaporanData[$field] = $documentPaths[$field];
            }

            $laporanTat->update($updateLaporanData);

            // 4. Update relasi many-to-many dengan tersangka
            $laporanTat->tersangka()->sync($tersangkaIds);

            // 5. Hapus file-file lama setelah update berhasil
            foreach ($filesToDelete as $filePath) {
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            DB::commit();

            return redirect()
                ->route('operator.laporan.edit', $laporanTat->id)
                ->with('success', 'Laporan TAT berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            // Hapus file baru yang sudah terupload jika terjadi error
            foreach ($documentPaths ?? [] as $field => $path) {
                if ($path && $path !== $laporanTat->{$field} && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui laporan: ' . $e->getMessage());
        }
    }

    private function deleteFileFromStorage($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return true;
        }
        return false;
    }

    /**
     * Helper method untuk hapus multiple files
     */
    private function deleteMultipleFiles($filePaths)
    {
        $deletedCount = 0;
        foreach ($filePaths as $filePath) {
            if ($this->deleteFileFromStorage($filePath)) {
                $deletedCount++;
            }
        }
        return $deletedCount;
    }

    /**
     * Hapus laporan TAT (Hard Delete)
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Cari laporan dengan relasi tersangka
            $laporanTat = LaporanTAT::with('tersangka')->findOrFail($id);

            // Array untuk menyimpan semua file yang akan dihapus
            $filesToDelete = [];

            // 1. Kumpulkan semua file dokumen laporan
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
                if ($laporanTat->{$field}) {
                    $filesToDelete[] = $laporanTat->{$field};
                }
            }

            // 2. Kumpulkan foto KTP tersangka (hanya jika tersangka tidak digunakan laporan lain)
            foreach ($laporanTat->tersangka as $tersangka) {
                // Cek apakah tersangka ini digunakan di laporan lain
                $otherLaporanCount = $tersangka->laporanTat()
                    ->where('laporan_tat.id', '!=', $laporanTat->id)
                    ->count();

                // Jika tersangka tidak digunakan di laporan lain, hapus foto KTP
                if ($otherLaporanCount == 0 && $tersangka->foto_ktp) {
                    $filesToDelete[] = $tersangka->foto_ktp;
                }
            }

            // 3. Hapus relasi many-to-many dengan tersangka
            $laporanTat->tersangka()->detach();

            // 4. Hapus tersangka yang tidak digunakan di laporan lain
            foreach ($laporanTat->tersangka as $tersangka) {
                $otherLaporanCount = $tersangka->laporanTat()->count();
                if ($otherLaporanCount == 0) {
                    $tersangka->delete();
                }
            }

            // 5. Hapus record laporan dari database
            $nomorSurat = $laporanTat->nomor_surat_permohonan_tat;
            $laporanTat->delete();

            // 6. Hapus semua file setelah database berhasil dihapus
            $deletedFilesCount = $this->deleteMultipleFiles($filesToDelete);

            DB::commit();

            return redirect()
                ->route('operator.laporan.index')
                ->with('success', "Laporan TAT nomor {$nomorSurat} berhasil dihapus beserta {$deletedFilesCount} file.");
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
        }
    }
}
