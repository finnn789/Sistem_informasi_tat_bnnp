@extends('layouts.admin')

@section('content')
<style>
    body {
        background-image: url('/images/bg.jpeg');
        background-size: contain; /* atau coba 100% auto untuk menyesuaikan lebar */
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: top center;
    }

    .bg-overlay {
        background-color: rgba(255, 255, 255, 0.88);
        padding: 1.5rem;
        border-radius: 0.5rem;
    }
</style>

<div class="p-6 bg-white/20 shadow-lg rounded-lg backdrop-blur">
    <h1 class="text-2xl font-bold mb-4">Dashboard Tim Assesment</h1>
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-500 text-white p-4 rounded shadow">
            <p class="text-sm">Total Laporan</p>
            <p class="text-2xl font-bold">{{ $total ?? 0 }}</p>
        </div>
        <div class="bg-green-500 text-white p-4 rounded shadow">
            <p class="text-sm">Diterima</p>
            <p class="text-2xl font-bold">{{ $diterima ?? 0 }}</p>
        </div>

        <div class="bg-yellow-500 text-white p-4 rounded shadow">
            <p class="text-sm">Menunggu</p>
            <p class="text-2xl font-bold">{{ $menunggu ?? 0 }}</p>
        </div>
        <div class="bg-red-500 text-white p-4 rounded shadow">
            <p class="text-sm">Ditolak</p>
            <p class="text-2xl font-bold">{{ $ditolak ?? 0 }}</p>
        </div>
    </div>


    

    <table class="w-full border text-left">
        <thead class="bg-gray-100">
            {{-- Tambahkan header jika diperlukan --}}
        </thead>
        <tbody>
            {{-- Data laporan bisa di-loop di sini --}}
        </tbody>
    </table>
</div>
@endsection
