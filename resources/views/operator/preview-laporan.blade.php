{{-- resources/views/laporan-tat/preview.blade.php --}}
@extends('layouts.form')
@section('title', 'Preview Laporan ')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.min.js"></script>
    <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-[#003366]">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-[#003366] to-blue-800 px-8 py-6 text-center relative">
                    <h4 class="text-2xl font-bold text-white mb-2">Preview Laporan TAT</h4>
                    <p class="text-blue-100 text-sm">(Tes Alkohol dan Narkoba)</p>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-[#FFD700] rounded-full">
                    </div>
                </div>

                {{-- Status Badge --}}
                <div class="px-8 pt-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-600">Status Laporan:</span>
                            @php
                                $statusConfig = [
                                    'Menunggu' => [
                                        'bg-yellow-100',
                                        'text-yellow-800',
                                        'border-yellow-300',
                                        'Menunggu Review',
                                    ],
                                    'diterima' => ['bg-green-100', 'text-green-800', 'border-green-300', 'Diterima'],
                                    'ditolak' => ['bg-red-100', 'text-red-800', 'border-red-300', 'Ditolak'],
                                ];
                                $config = $statusConfig[$laporan->status] ?? $statusConfig['pending'];
                                // dd($laporan->status);
                            @endphp
                            <span
                                class="px-4 py-2 rounded-full border {{ $config[0] }} {{ $config[1] }} {{ $config[2] }} font-semibold text-sm">
                                {{ $config[3] }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Dibuat:</span> {{ $laporan->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="p-8">
                    {{-- Data Tersangka Section --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-l-4 border-[#FFD700] mb-8">
                        <h5 class="text-xl font-semibold text-[#003366] mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-[#FFD700]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Data Tersangka
                        </h5>

                        <div class="space-y-6">
                            @foreach ($laporan->tersangka as $index => $tersangka)
                                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                                    <div class="border-b border-gray-200 pb-4 mb-6">
                                        <h6 class="text-lg font-semibold text-[#003366]">Tersangka {{ $index + 1 }}</h6>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Nama Lengkap
                                            </label>
                                            <div
                                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800">
                                                {{ $tersangka->nama }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                No. KTP
                                            </label>
                                            <div
                                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800">
                                                {{ $tersangka->no_ktp }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Jenis Kelamin
                                            </label>
                                            <div
                                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800">
                                                {{ $tersangka->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Tanggal Lahir
                                            </label>
                                            <div
                                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800">
                                                {{ \Carbon\Carbon::parse($tersangka->tanggal_lahir)->format('d F Y') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                        <div class="lg:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Alamat
                                            </label>
                                            <div
                                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800 min-h-[80px]">
                                                {{ $tersangka->alamat }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Foto KTP
                                            </label>
                                            @if ($tersangka->foto_ktp)
                                                <div class="bg-white border-2 border-gray-200 rounded-lg p-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span
                                                                class="text-sm text-gray-700 font-medium">{{ basename($tersangka->foto_ktp) }}</span>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $tersangka->foto_ktp) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                                <path fill-rule="evenodd"
                                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Lihat
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <div
                                                    class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-center text-gray-500">
                                                    Tidak ada file
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Laporan TAT Section --}}
                    <div
                        class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-6 border-l-4 border-[#003366] mb-8">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kronologis
                            </label>
                            <div
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-800 min-h-[120px] whitespace-pre-wrap">
                                {{ $laporan->kronologis }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Surat Laporan
                            </label>
                            <div class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-800">
                                {{ $laporan->nomor_surat_permohonan_tat }}
                            </div>
                        </div>
                    </div>

                    {{-- Document Upload Section --}}
                    <div class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl p-6 border-l-4 border-[#FFD700] mb-8">
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Surat Permohonan TAT
                                </label>
                                @if ($laporan->surat_permohonan_tat)
                                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-sm text-gray-700 font-medium">{{ basename($laporan->surat_permohonan_tat) }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $laporan->surat_permohonan_tat) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-center text-gray-500">
                                        Tidak ada file
                                    </div>
                                @endif
                            </div>

                            {{-- Surat Persetujuan TAT --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Surat Persetujuan TAT
                                </label>
                                @if ($laporan->surat_persetujuan_tat)
                                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-sm text-gray-700 font-medium">{{ basename($laporan->surat_persetujuan_tat) }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $laporan->surat_persetujuan_tat) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-center text-gray-500">
                                        Tidak ada file
                                    </div>
                                @endif
                            </div>

                            {{-- Surat Pernyataan Penyidik --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Surat Pernyataan Penyidik
                                </label>
                                @if ($laporan->surat_pernyataan_penyidik)
                                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-sm text-gray-700 font-medium">{{ basename($laporan->surat_pernyataan_penyidik) }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $laporan->surat_pernyataan_penyidik) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-center text-gray-500">
                                        Tidak ada file
                                    </div>
                                @endif
                            </div>

                            {{-- Tanggal Pelaksanaan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Pelaksanaan
                                </label>
                                <div class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800">
                                    @if ($laporan->tanggal_pelaksanaan)
                                        {{ \Carbon\Carbon::parse($laporan->tanggal_pelaksanaan)->format('d F Y') }}
                                    @else
                                        <span class="text-gray-500">Belum ditentukan</span>
                                    @endif
                                </div>
                            </div>

                            {{-- File Surat Penerimaan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    File Surat Penerimaan
                                </label>
                                @if ($laporan->file_surat_penerimaan)
                                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-sm text-gray-700 font-medium">{{ basename($laporan->file_surat_penerimaan) }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $laporan->file_surat_penerimaan) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-center text-gray-500">
                                        Tidak ada file
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Status Information Section (if rejected or approved) --}}
                    @if ($laporan->status !== 'pending')
                        <div
                            class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border-l-4 border-gray-400 mb-8">
                            <h6 class="text-lg font-semibold text-gray-700 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Informasi Status
                            </h6>

                            @if ($laporan->status === 'diterima')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-green-800">Laporan Disetujui</h3>
                                            <div class="mt-2 text-sm text-green-700">
                                                @if ($laporan->approved_at)
                                                    <p><span class="font-medium">Tanggal Persetujuan:</span>
                                                        {{ \Carbon\Carbon::parse($laporan->approved_at)->format('d F Y, H:i') }}
                                                    </p>
                                                @endif
                                                @if ($laporan->approved_by)
                                                    <p><span class="font-medium">Disetujui oleh:</span>
                                                        {{ $laporan->approvedBy->name ?? 'Admin' }}</p>
                                                @endif
                                                @if ($laporan->jadwal_pemeriksaan)
                                                    <p><span class="font-medium">Jadwal Pemeriksaan:</span>
                                                        {{ \Carbon\Carbon::parse($laporan->jadwal_pemeriksaan)->format('d F Y, H:i') }}
                                                    </p>
                                                @endif
                                                @if ($laporan->keterangan_approval)
                                                    <p><span class="font-medium">Keterangan:</span>
                                                        {{ $laporan->keterangan_approval }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($laporan->status === 'rejected')
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-red-800">Laporan Ditolak</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                @if ($laporan->rejected_at)
                                                    <p><span class="font-medium">Tanggal Penolakan:</span>
                                                        {{ \Carbon\Carbon::parse($laporan->rejected_at)->format('d F Y, H:i') }}
                                                    </p>
                                                @endif
                                                @if ($laporan->rejected_by)
                                                    <p><span class="font-medium">Ditolak oleh:</span>
                                                        {{ $laporan->rejectedBy->name ?? 'Admin' }}</p>
                                                @endif
                                                @if ($laporan->alasan_penolakan)
                                                    <p><span class="font-medium">Alasan Penolakan:</span></p>
                                                    <div class="mt-1 p-3 bg-red-100 rounded text-red-800">
                                                        {{ $laporan->alasan_penolakan }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="bg-gray-50 rounded-xl p-6 no-print">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('operator.dashboard') }}"
                                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Kembali ke Dashboard
                            </a>

                            <div class="flex space-x-3">
                                {{-- Print Button --}}
                                <button onclick="window.print()"
                                    class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Cetak
                                </button>

                                {{-- Edit Button (only if status is pending or rejected) --}}
                                @if (in_array($laporan->status, ['pending', 'rejected']))
                                    <a href="{{ route('operator.laporan.edit', $laporan->id) }}"
                                        class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                            </path>
                                        </svg>
                                        Edit Laporan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .bg-gradient-to-br,
            .bg-gradient-to-r {
                background: white !important;
            }

            .shadow-2xl,
            .shadow-lg,
            .shadow-xl {
                box-shadow: none !important;
            }

            .border-t-4 {
                border-top: 4px solid #003366 !important;
            }

            .rounded-2xl,
            .rounded-xl,
            .rounded-lg {
                border-radius: 8px !important;
            }
        }
    </style>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 3000
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

@endsection
