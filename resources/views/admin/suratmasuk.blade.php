@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Surat Masuk</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded p-4">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Surat Pengajuan</th>
                    <th class="px-4 py-2 text-left">Tanggal Pengajuan</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $index => $laporan)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $laporan->nomor_surat_permohonan_tat }}</td>
                        <td class="px-4 py-2">{{ $laporan->created_at->format('d M Y') }}</td>
                     
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                               class="text-blue-500 hover:underline">Preview</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada laporan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
