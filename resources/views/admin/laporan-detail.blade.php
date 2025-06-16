@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Laporan Masuk</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Sidebar daftar dokumen --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Daftar Dokumen</h2>
            <ul class="space-y-2">
                @php
                    $dokumenList = [
                        'surat_permohonan_tat' => 'Surat Permohonan TAT',
                        'surat_perintah_penangkapan' => 'Surat Perintah Penangkapan',
                        'laporan_polisi' => 'Laporan Polisi',
                        'surat_perintah_penyidikan' => 'Surat Perintah Penyidikan',
                        'surat_uji_laboratorium' => 'Surat Uji Laboratorium',
                        'berita_acara_pemeriksaan_tersangka' => 'Berita Acara Pemeriksaan',
                        'surat_persetujuan_tat' => 'Surat Persetujuan TAT',
                        'surat_pernyataan_penyidik' => 'Surat Pernyataan Penyidik',
                        'file_surat_penerimaan' => 'Surat Penerimaan TAT',
                    ];
                @endphp

                @foreach ($dokumenList as $field => $label)
                    @if ($laporan->$field)
                        <li class="flex justify-between items-center">
                            <span>{{ $label }}</span>
                            <a href="{{ route('admin.laporan.preview', ['id' => $laporan->id, 'field' => $field]) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Preview
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        {{-- Panel preview --}}
        <div class="md:col-span-2">
            @if (session('preview_path'))
                <h2 class="text-lg font-semibold mb-4">Preview Dokumen</h2>
                <iframe src="{{ asset('storage/' . session('preview_path')) }}" width="100%" height="600px" class="border rounded"></iframe>
            @else
                <p class="text-gray-500 italic">Silakan klik "Preview" untuk melihat dokumen.</p>
            @endif

            {{-- Tombol Setujui / Tolak --}}
            <div class="flex space-x-4 mt-6">
                <form action="{{ route('admin.laporan.setujui', $laporan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Setujui
                    </button>
                </form>

                <form action="{{ route('admin.laporan.tolak', $laporan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
