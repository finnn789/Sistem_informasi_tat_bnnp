{{-- resources/views/laporan-tat/edit.blade.php --}}
@extends('layouts.form')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.js"></script>
    <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-[#003366]">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-[#003366] to-blue-800 px-8 py-6 text-center relative">
                    <h4 class="text-2xl font-bold text-white mb-2">Edit Laporan TAT</h4>
                    <p class="text-blue-100 text-sm">(Tes Alkohol dan Narkoba)</p>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-[#FFD700] rounded-full">
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="p-8">
                    <form action="{{ route('operator.laporan.update', $laporan->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        {{-- Data Tersangka Section --}}
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-l-4 border-[#FFD700]">
                            <h5 class="text-xl font-semibold text-[#003366] mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-[#FFD700]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Data Tersangka
                            </h5>

                            <div id="tersangka-fields" class="space-y-6">
                                @foreach ($laporan->tersangka as $index => $tersangka)
                                    <div class="tersangka-field bg-white rounded-lg p-6 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300"
                                        id="tersangka-{{ $index + 1 }}">
                                        <div class="border-b border-gray-200 pb-4 mb-6">
                                            <h6 class="text-lg font-semibold text-[#003366]">Tersangka {{ $index + 1 }}
                                            </h6>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                            <div>
                                                <label for="tersangka_nama_{{ $index + 1 }}"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nama Lengkap <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text"
                                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('tersangka.*.nama') border-red-500 @enderror"
                                                    name="tersangka[{{ $index }}][nama]"
                                                    placeholder="Masukkan nama lengkap tersangka"
                                                    value="{{ old('tersangka.' . $index . '.nama', $tersangka->nama) }}">
                                                @error('tersangka.' . $index . '.nama')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="tersangka_no_ktp_{{ $index + 1 }}"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    No. KTP <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text"
                                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 ktp-input @error('tersangka.*.no_ktp') border-red-500 @enderror"
                                                    name="tersangka[{{ $index }}][no_ktp]"
                                                    placeholder="Masukkan 16 digit nomor KTP" maxlength="16"
                                                    pattern="[0-9]{16}"
                                                    value="{{ old('tersangka.' . $index . '.no_ktp', $tersangka->no_ktp) }}">
                                                @error('tersangka.' . $index . '.no_ktp')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                            <div>
                                                <label for="tersangka_jenis_kelamin_{{ $index + 1 }}"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Jenis Kelamin <span class="text-red-500">*</span>
                                                </label>
                                                <select
                                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('tersangka.*.jenis_kelamin') border-red-500 @enderror"
                                                    name="tersangka[{{ $index }}][jenis_kelamin]">
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="L"
                                                        {{ old('tersangka.' . $index . '.jenis_kelamin', $tersangka->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="P"
                                                        {{ old('tersangka.' . $index . '.jenis_kelamin', $tersangka->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                                @error('tersangka.' . $index . '.jenis_kelamin')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="tersangka_tanggal_lahir_{{ $index + 1 }}"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Tanggal Lahir <span class="text-red-500">*</span>
                                                </label>
                                                <input type="date"
                                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('tersangka.*.tanggal_lahir') border-red-500 @enderror"
                                                    name="tersangka[{{ $index }}][tanggal_lahir]"
                                                    value="{{ old('tersangka.' . $index . '.tanggal_lahir', $tersangka->tanggal_lahir) }}">
                                                @error('tersangka.' . $index . '.tanggal_lahir')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                            <div class="lg:col-span-2">
                                                <label for="tersangka_alamat_{{ $index + 1 }}"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Alamat <span class="text-red-500">*</span>
                                                </label>
                                                <textarea
                                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('tersangka.*.alamat') border-red-500 @enderror"
                                                    name="tersangka[{{ $index }}][alamat]" rows="3" placeholder="Masukkan alamat lengkap tersangka">{{ old('tersangka.' . $index . '.alamat', $tersangka->alamat) }}</textarea>
                                                @error('tersangka.' . $index . '.alamat')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="tersangka_foto_ktp_{{ $index + 1 }}"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Foto KTP
                                                </label>

                                                {{-- Show existing file if available --}}
                                                @if ($tersangka->foto_ktp)
                                                    <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center">
                                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="text-sm text-green-700 font-medium">File saat
                                                                    ini: {{ basename($tersangka->foto_ktp) }}</span>
                                                            </div>
                                                            <a href="{{ asset('storage/' . $tersangka->foto_ktp) }}"
                                                                target="_blank"
                                                                class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="relative">
                                                    <input type="file" id="tersangka_foto_ktp_{{ $index + 1 }}"
                                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input z-10 @error('tersangka.*.foto_ktp') border-red-500 @enderror"
                                                        name="tersangka[{{ $index }}][foto_ktp]" accept="image/*">
                                                    <div
                                                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#FFD700] transition-colors duration-200 bg-gray-50 hover:bg-gray-100">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                            fill="none" viewBox="0 0 48 48">
                                                            <path
                                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                            </path>
                                                        </svg>
                                                        <div class="mt-4">
                                                            <span class="mt-2 block text-sm font-medium text-gray-900">
                                                                {{ $tersangka->foto_ktp ? 'Ganti Foto KTP' : 'Upload Foto KTP' }}
                                                            </span>
                                                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 text-xs text-gray-600 file-name hidden"></div>
                                                </div>
                                                @error('tersangka.' . $index . '.foto_ktp')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        @if (count($laporan->tersangka) > 1)
                                            <button type="button"
                                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 remove-tersangka">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"
                                                        clip-rule="evenodd"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Button Add Tersangka --}}
                            <div class="flex justify-end mt-6">
                                <button type="button" id="add-tersangka"
                                    class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Tambah Tersangka
                                </button>
                            </div>
                        </div>

                        {{-- Laporan TAT Section --}}
                        <div
                            class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-6 border-l-4 border-[#003366]">
                            <h5 class="text-xl font-semibold text-[#003366] mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-[#FFD700]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Data Laporan TAT
                            </h5>

                            <div class="mb-6">
                                <label for="kronologis" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kronologis <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('kronologis') border-red-500 @enderror"
                                    id="kronologis" name="kronologis" rows="5" placeholder="Jelaskan kronologis kejadian secara detail...">{{ old('kronologis', $laporan->kronologis) }}</textarea>
                                @error('kronologis')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nomor_surat_permohonan_tat"
                                    class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Surat Laporan <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('nomor_surat_permohonan_tat') border-red-500 @enderror"
                                    id="nomor_surat_permohonan_tat" name="nomor_surat_permohonan_tat"
                                    placeholder="SR12/2023/01/01..."
                                    value="{{ old('nomor_surat_permohonan_tat', $laporan->nomor_surat_permohonan_tat) }}">
                                @error('nomor_surat_permohonan_tat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Document Upload Section --}}
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl p-6 border-l-4 border-[#FFD700]">
                            <h6 class="text-lg font-semibold text-[#003366] mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-[#FFD700]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Dokumen Pendukung
                            </h6>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Surat Permohonan TAT --}}
                                <div>
                                    <label for="surat_permohonan_tat"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Surat Permohonan TAT <span class="text-red-500">*</span>
                                    </label>

                                    @if ($laporan->surat_permohonan_tat)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->surat_permohonan_tat) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->surat_permohonan_tat) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>

                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('surat_permohonan_tat') border-red-500 @enderror"
                                        id="surat_permohonan_tat" name="surat_permohonan_tat" accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->surat_permohonan_tat ? 'Kosongkan jika tidak ingin mengubah file' : 'Wajib diisi' }}
                                    </p>
                                    @error('surat_permohonan_tat')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Surat Perintah Penangkapan --}}
                                <div>
                                    <label for="surat_perintah_penangkapan"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Surat Perintah Penangkapan <span class="text-red-500">*</span>
                                    </label>

                                    @if ($laporan->surat_perintah_penangkapan)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->surat_perintah_penangkapan) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->surat_perintah_penangkapan) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('surat_perintah_penangkapan') border-red-500 @enderror"
                                        id="surat_perintah_penangkapan" name="surat_perintah_penangkapan"
                                        accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->surat_perintah_penangkapan ? 'Kosongkan jika tidak ingin mengubah file' : 'Wajib diisi' }}
                                    </p>
                                    @error('surat_perintah_penangkapan')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Laporan Polisi --}}
                                <div>
                                    <label for="laporan_polisi" class="block text-sm font-medium text-gray-700 mb-2">
                                        Laporan Polisi
                                    </label>

                                    @if ($laporan->laporan_polisi)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->laporan_polisi) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->laporan_polisi) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('laporan_polisi') border-red-500 @enderror"
                                        id="laporan_polisi" name="laporan_polisi" accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('laporan_polisi')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Surat Perintah Penyidikan --}}
                                <div>
                                    <label for="surat_perintah_penyidikan"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Surat Perintah Penyidikan
                                    </label>

                                    @if ($laporan->surat_perintah_penyidikan)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->surat_perintah_penyidikan) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->surat_perintah_penyidikan) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('surat_perintah_penyidikan') border-red-500 @enderror"
                                        id="surat_perintah_penyidikan" name="surat_perintah_penyidikan"
                                        accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('surat_perintah_penyidikan')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Surat Uji Laboratorium --}}
                                <div>
                                    <label for="surat_uji_laboratorium"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Surat Uji Laboratorium
                                    </label>

                                    @if ($laporan->surat_uji_laboratorium)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->surat_uji_laboratorium) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->surat_uji_laboratorium) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>

                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('surat_uji_laboratorium') border-red-500 @enderror"
                                        id="surat_uji_laboratorium" name="surat_uji_laboratorium"
                                        accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('surat_uji_laboratorium')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Berita Acara Pemeriksaan Tersangka --}}
                                <div>
                                    <label for="berita_acara_pemeriksaan_tersangka"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Berita Acara Pemeriksaan Tersangka
                                    </label>

                                    @if ($laporan->berita_acara_pemeriksaan_tersangka)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->berita_acara_pemeriksaan_tersangka) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->berita_acara_pemeriksaan_tersangka) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('berita_acara_pemeriksaan_tersangka') border-red-500 @enderror"
                                        id="berita_acara_pemeriksaan_tersangka" name="berita_acara_pemeriksaan_tersangka"
                                        accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('berita_acara_pemeriksaan_tersangka')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Surat Persetujuan TAT --}}
                                <div>
                                    <label for="surat_persetujuan_tat"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Surat Persetujuan TAT
                                    </label>

                                    @if ($laporan->surat_persetujuan_tat)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->surat_persetujuan_tat) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->surat_persetujuan_tat) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('surat_persetujuan_tat') border-red-500 @enderror"
                                        id="surat_persetujuan_tat" name="surat_persetujuan_tat" accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('surat_persetujuan_tat')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Surat Pernyataan Penyidik --}}
                                <div>
                                    <label for="surat_pernyataan_penyidik"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Surat Pernyataan Penyidik
                                    </label>

                                    @if ($laporan->surat_pernyataan_penyidik)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->surat_pernyataan_penyidik) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->surat_pernyataan_penyidik) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('surat_pernyataan_penyidik') border-red-500 @enderror"
                                        id="surat_pernyataan_penyidik" name="surat_pernyataan_penyidik"
                                        accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('surat_pernyataan_penyidik')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tanggal Pelaksanaan --}}
                                <div>
                                    <label for="tanggal_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Pelaksanaan
                                    </label>
                                    <input type="date"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('tanggal_pelaksanaan') border-red-500 @enderror"
                                        id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                                        value="{{ old('tanggal_pelaksanaan', $laporan->tanggal_pelaksanaan) }}">
                                    @error('tanggal_pelaksanaan')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- File Surat Penerimaan --}}
                                <div>
                                    <label for="file_surat_penerimaan"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        File Surat Penerimaan
                                    </label>

                                    @if ($laporan->file_surat_penerimaan)
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-700 font-medium">File saat ini:
                                                        {{ basename($laporan->file_surat_penerimaan) }}</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $laporan->file_surat_penerimaan) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file"
                                        class="w-full px-4 py-3 border-2  rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 @error('file_surat_penerimaan') border-red-500 @enderror"
                                        id="file_surat_penerimaan" name="file_surat_penerimaan" accept=".pdf,.doc,.docx">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file</p>
                                    @error('file_surat_penerimaan')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div
                                class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('operator.dashboard') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Kembali
                                </a>
                                <div class="flex space-x-3">
                                    
                                    <button type="submit"
                                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-[#003366] to-blue-800 hover:from-blue-800 hover:to-[#003366] text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Update Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- JavaScript untuk validasi dan enhancement --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 3000
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('operator.dashboard') }}";
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: true
            });
        </script>
    @endif

    <script>
        function resetForm() {
            Swal.fire({
                title: 'Reset Form?',
                text: 'Semua perubahan akan hilang dan kembali ke data awal',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial tersangka count based on existing data
            let tersangkaCount = {{ count($laporan->tersangka) }};

            // File size validation with better feedback
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    const file = this.files[0];
                    const container = this.closest('.relative') || this.parentElement;
                    const fileNameDiv = container.querySelector('.file-name');

                    if (file) {
                        if (file.size > maxSize) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file maksimal 2MB',
                                confirmButtonText: 'OK'
                            });
                            this.value = '';
                            this.classList.add('border-red-500');
                            if (fileNameDiv) {
                                fileNameDiv.textContent = '';
                                fileNameDiv.classList.add('hidden');
                            }
                        } else {
                            this.classList.remove('border-red-500');
                            this.classList.add('border-green-500');
                            if (fileNameDiv) {
                                fileNameDiv.textContent = `File dipilih: ${file.name}`;
                                fileNameDiv.classList.remove('hidden');
                                fileNameDiv.classList.add('text-green-600');
                            }
                        }
                    } else {
                        if (fileNameDiv) {
                            fileNameDiv.textContent = '';
                            fileNameDiv.classList.add('hidden');
                        }
                    }
                });
            });

            // Form confirmation before submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: 'Apakah Anda yakin ingin mengupdate laporan ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#003366',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });



            // Function to add new tersangka field
            document.getElementById('add-tersangka').addEventListener('click', function() {
                tersangkaCount++;

                const tersangkaField = document.createElement('div');
                tersangkaField.classList.add('tersangka-field', 'bg-white', 'rounded-lg', 'p-6', 'border',
                    'border-gray-200', 'shadow-sm', 'hover:shadow-md', 'transition-all', 'duration-300');
                tersangkaField.innerHTML = `
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h6 class="text-lg font-semibold text-[#003366]">Tersangka ${tersangkaCount}</h6>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tersangka_nama_${tersangkaCount}" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200" 
                           name="tersangka[${tersangkaCount - 1}][nama]" 
                           placeholder="Masukkan nama lengkap tersangka">
                </div>
                <div>
                    <label for="tersangka_no_ktp_${tersangkaCount}" class="block text-sm font-medium text-gray-700 mb-2">
                        No. KTP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200 ktp-input" 
                           name="tersangka[${tersangkaCount - 1}][no_ktp]" 
                           placeholder="Masukkan 16 digit nomor KTP"
                           maxlength="16"
                           pattern="[0-9]{16}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tersangka_jenis_kelamin_${tersangkaCount}" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200" 
                            name="tersangka[${tersangkaCount - 1}][jenis_kelamin]">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label for="tersangka_tanggal_lahir_${tersangkaCount}" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200" 
                           name="tersangka[${tersangkaCount - 1}][tanggal_lahir]">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2">
                    <label for="tersangka_alamat_${tersangkaCount}" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#FFD700] focus:ring-2 focus:ring-[#FFD700]/20 transition-colors duration-200" 
                              name="tersangka[${tersangkaCount - 1}][alamat]" 
                              rows="3" 
                              placeholder="Masukkan alamat lengkap tersangka"></textarea>
                </div>
                <div>
                    <label for="tersangka_foto_ktp_${tersangkaCount}" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto KTP
                    </label>
                    <div class="relative">
                        <input type="file" 
                               id="tersangka_foto_ktp_${tersangkaCount}"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input z-10" 
                               name="tersangka[${tersangkaCount - 1}][foto_ktp]" 
                               accept="image/*">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#FFD700] transition-colors duration-200 bg-gray-50 hover:bg-gray-100">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <div class="mt-4">
                                <span class="mt-2 block text-sm font-medium text-gray-900">Upload Foto KTP</span>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-600 file-name hidden"></div>
                    </div>
                </div>
            </div>

            <button type="button" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 remove-tersangka">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                Hapus
            </button>
        `;

                document.getElementById('tersangka-fields').appendChild(tersangkaField);

                // Add event listeners for new KTP input
                const newKtpInputs = tersangkaField.querySelectorAll('.ktp-input');
                newKtpInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        this.value = this.value.replace(/\D/g, '').substring(0, 16);
                    });
                });

                // Add event listeners for new file inputs
                const newFileInputs = tersangkaField.querySelectorAll('.file-input');
                newFileInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        const file = this.files[0];
                        const container = this.closest('.relative') || this.parentElement;
                        const fileNameDiv = container.querySelector('.file-name');

                        if (file) {
                            if (file.size > maxSize) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'File Terlalu Besar',
                                    text: 'Ukuran file maksimal 2MB',
                                    confirmButtonText: 'OK'
                                });
                                this.value = '';
                                this.classList.add('border-red-500');
                                if (fileNameDiv) {
                                    fileNameDiv.textContent = '';
                                    fileNameDiv.classList.add('hidden');
                                }
                            } else {
                                this.classList.remove('border-red-500');
                                this.classList.add('border-green-500');
                                if (fileNameDiv) {
                                    fileNameDiv.textContent = `File dipilih: ${file.name}`;
                                    fileNameDiv.classList.remove('hidden');
                                    fileNameDiv.classList.add('text-green-600');
                                }
                            }
                        } else {
                            if (fileNameDiv) {
                                fileNameDiv.textContent = '';
                                fileNameDiv.classList.add('hidden');
                            }
                        }
                    });
                });
            });



            // KTP number validation for all KTP inputs (including initial ones)
            const ktpInputs = document.querySelectorAll('.ktp-input, input[name*="no_ktp"]');
            ktpInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').substring(0, 16);
                });
            });

            // Function to remove tersangka field
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-tersangka') || e.target.closest(
                        '.remove-tersangka')) {
                    const tersangkaField = e.target.closest('.tersangka-field');
                    const remainingFields = document.querySelectorAll('.tersangka-field').length;

                    if (remainingFields <= 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Dapat Dihapus',
                            text: 'Minimal harus ada satu tersangka',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    if (tersangkaField) {
                        Swal.fire({
                            title: 'Hapus Tersangka?',
                            text: 'Data tersangka akan dihapus',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                tersangkaField.remove();
                            }
                        });
                    }
                }
            });

            // File upload preview for all KTP inputs
            document.addEventListener('change', function(e) {
                if (e.target.name && e.target.name.includes('[foto_ktp]')) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            console.log('File uploaded:', file.name);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });

        // @include('layouts.modal-preview')
    </script>
@endsection
