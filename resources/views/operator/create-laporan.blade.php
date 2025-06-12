{{-- resources/views/laporan-tat/create.blade.php --}}
@extends('layouts.form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Laporan TAT (Tes Alkohol dan Narkoba)</h4>
                </div>
                <div class="card-body">
                    <form action={{ route('operator.laporan.store') }} method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        
                        {{-- Data Tersangka Section --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Data Tersangka</h5>
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tersangka_nama" class="form-label">Nama Tersangka <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tersangka_nama') is-invalid @enderror" 
                                       id="tersangka_nama" name="tersangka_nama" value="{{ old('tersangka_nama') }}" required>
                                @error('tersangka_nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tersangka_no_ktp" class="form-label">No. KTP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tersangka_no_ktp') is-invalid @enderror" 
                                       id="tersangka_no_ktp" name="tersangka_no_ktp" value="{{ old('tersangka_no_ktp') }}" required>
                                @error('tersangka_no_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tersangka_jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('tersangka_jenis_kelamin') is-invalid @enderror" 
                                        id="tersangka_jenis_kelamin" name="tersangka_jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('tersangka_jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('tersangka_jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('tersangka_jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tersangka_tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tersangka_tanggal_lahir') is-invalid @enderror" 
                                       id="tersangka_tanggal_lahir" name="tersangka_tanggal_lahir" value="{{ old('tersangka_tanggal_lahir') }}" required>
                                @error('tersangka_tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                      <div id="tersangka-fields">
                            <div class="tersangka-field mb-3" id="tersangka-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tersangka_nama_1" class="form-label">Nama Tersangka 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tersangka.*.nama') is-invalid @enderror" 
                                               name="tersangka[0][nama]" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tersangka_peran_1" class="form-label">Peran Tersangka 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tersangka.*.peran') is-invalid @enderror" 
                                               name="tersangka[0][peran]" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-tersangka">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Button Add Tersangka -->
                        <div class="text-end mb-4">
                            <button type="button" id="add-tersangka" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Tersangka
                            </button>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="tersangka_alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('tersangka_alamat') is-invalid @enderror" 
                                          id="tersangka_alamat" name="tersangka_alamat" rows="3" required>{{ old('tersangka_alamat') }}</textarea>
                                @error('tersangka_alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tersangka_foto_ktp" class="form-label">Foto KTP</label>
                                <input type="file" class="form-control @error('tersangka_foto_ktp') is-invalid @enderror" 
                                       id="tersangka_foto_ktp" name="tersangka_foto_ktp" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                @error('tersangka_foto_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Laporan TAT Section --}}
                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Data Laporan TAT</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="kronologis" class="form-label">Kronologis <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('kronologis') is-invalid @enderror" 
                                          id="kronologis" name="kronologis" rows="4" required 
                                          placeholder="Jelaskan kronologis kejadian secara detail">{{ old('kronologis') }}</textarea>
                                @error('kronologis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Document Upload Section --}}
                        <div class="row mb-4 mt-4">
                            <div class="col-12">
                                <h6 class="text-secondary border-bottom pb-2">Dokumen Pendukung</h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surat_permohonan_tat" class="form-label">Surat Permohonan TAT <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('surat_permohonan_tat') is-invalid @enderror" 
                                       id="surat_permohonan_tat" name="surat_permohonan_tat" accept=".pdf,.doc,.docx" required>
                                @error('surat_permohonan_tat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="surat_perintah_penangkapan" class="form-label">Surat Perintah Penangkapan</label>
                                <input type="file" class="form-control @error('surat_perintah_penangkapan') is-invalid @enderror" 
                                       id="surat_perintah_penangkapan" name="surat_perintah_penangkapan" accept=".pdf,.doc,.docx">
                                @error('surat_perintah_penangkapan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="laporan_polisi" class="form-label">Laporan Polisi</label>
                                <input type="file" class="form-control @error('laporan_polisi') is-invalid @enderror" 
                                       id="laporan_polisi" name="laporan_polisi" accept=".pdf,.doc,.docx">
                                @error('laporan_polisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="surat_perintah_penyidikan" class="form-label">Surat Perintah Penyidikan</label>
                                <input type="file" class="form-control @error('surat_perintah_penyidikan') is-invalid @enderror" 
                                       id="surat_perintah_penyidikan" name="surat_perintah_penyidikan" accept=".pdf,.doc,.docx">
                                @error('surat_perintah_penyidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surat_uji_laboratorium" class="form-label">Surat Uji Laboratorium</label>
                                <input type="file" class="form-control @error('surat_uji_laboratorium') is-invalid @enderror" 
                                       id="surat_uji_laboratorium" name="surat_uji_laboratorium" accept=".pdf,.doc,.docx">
                                @error('surat_uji_laboratorium')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="berita_acara_pemeriksaan_tersangka" class="form-label">Berita Acara Pemeriksaan Tersangka</label>
                                <input type="file" class="form-control @error('berita_acara_pemeriksaan_tersangka') is-invalid @enderror" 
                                       id="berita_acara_pemeriksaan_tersangka" name="berita_acara_pemeriksaan_tersangka" accept=".pdf,.doc,.docx">
                                @error('berita_acara_pemeriksaan_tersangka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surat_persetujuan_tat" class="form-label">Surat Persetujuan TAT</label>
                                <input type="file" class="form-control @error('surat_persetujuan_tat') is-invalid @enderror" 
                                       id="surat_persetujuan_tat" name="surat_persetujuan_tat" accept=".pdf,.doc,.docx">
                                @error('surat_persetujuan_tat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="surat_pernyataan_penyidik" class="form-label">Surat Pernyataan Penyidik</label>
                                <input type="file" class="form-control @error('surat_pernyataan_penyidik') is-invalid @enderror" 
                                       id="surat_pernyataan_penyidik" name="surat_pernyataan_penyidik" accept=".pdf,.doc,.docx">
                                @error('surat_pernyataan_penyidik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" 
                                       id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}">
                                @error('tanggal_pelaksanaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="file_surat_penerimaan" class="form-label">File Surat Penerimaan</label>
                                <input type="file" class="form-control @error('file_surat_penerimaan') is-invalid @enderror" 
                                       id="file_surat_penerimaan" name="file_surat_penerimaan" accept=".pdf,.doc,.docx">
                                @error('file_surat_penerimaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-warning me-2">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript untuk validasi dan enhancement --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File size validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (this.files[0] && this.files[0].size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
            }
        });
    });

    // KTP number validation (16 digits)
    const ktpInput = document.getElementById('tersangka_no_ktp');
    ktpInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 16);
    });

    // Form confirmation before submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!confirm('Apakah Anda yakin ingin menyimpan laporan ini?')) {
            e.preventDefault();
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    let tersangkaCount = 1;  // Initial count of tersangka fields

    // Function to add new tersangka field
    document.getElementById('add-tersangka').addEventListener('click', function() {
        tersangkaCount++;

        const tersangkaField = document.createElement('div');
        tersangkaField.classList.add('tersangka-field', 'mb-3');
        tersangkaField.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label for="tersangka_nama_${tersangkaCount}" class="form-label">Nama Tersangka ${tersangkaCount} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tersangka[${tersangkaCount - 1}][nama]" required>
                </div>
                <div class="col-md-6">
                    <label for="tersangka_peran_${tersangkaCount}" class="form-label">Peran Tersangka ${tersangkaCount} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tersangka[${tersangkaCount - 1}][peran]" required>
                </div>
            </div>
        `;
        
        document.getElementById('tersangka-fields').appendChild(tersangkaField);
    });
});
</script>
@endsection