<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan TAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .file-input-container {
            position: relative;
            margin-top: 0.5rem;
        }

        .file-input-container:hover .file-input-label {
            border-color: #6366f1;
        }

        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed #e5e7eb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            word-break: break-all;
        }
    </style>
    
</head>

<body>
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h1 class="text-xl font-semibold text-gray-900">Form Laporan TAT</h1>
                    <p class="mt-1 text-sm text-gray-500">Silakan lengkapi formulir berikut</p>
                </div>

                <form action="" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-6">
                    @csrf

                    <!-- Surat Permohonan TAT -->
                    <div>
                        <label for="surat_permohonan_tat" class="block text-sm font-medium text-gray-700">
                            Surat Permohonan TAT
                        </label>
                        <div class="file-input-container">
                            <label for="surat_permohonan_tat" class="file-input-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <span class="mt-2 text-sm text-gray-500">Klik untuk upload atau seret file ke
                                    sini</span>
                                <span class="mt-1 text-xs text-gray-400">SVG, PNG, JPG, atau GIF (Maks.
                                    800x400px)</span>
                                <input type="file" name="surat_permohonan_tat" id="surat_permohonan_tat"
                                    class="file-input" accept=".svg,.png,.jpg,.jpeg,.gif"
                                    aria-describedby="surat_permohonan_tat_help">
                            </label>
                            <div class="file-name" id="surat_permohonan_tat_name"></div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500" id="surat_permohonan_tat_help">
                            File yang diunggah akan digunakan sebagai dokumen pendukung laporan.
                        </p>
                    </div>

                    <!-- Surat Perintah Penangkapan -->
                    <div>
                        <label for="surat_perintah_penangkapan" class="block text-sm font-medium text-gray-700">
                            Surat Perintah Penangkapan
                        </label>
                        <div class="file-input-container">
                            <label for="surat_perintah_penangkapan" class="file-input-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <span class="mt-2 text-sm text-gray-500">Klik untuk upload atau seret file ke
                                    sini</span>
                                <span class="mt-1 text-xs text-gray-400">SVG, PNG, JPG, atau GIF (Maks.
                                    800x400px)</span>
                                <input type="file" name="surat_perintah_penangkapan" id="surat_perintah_penangkapan"
                                    class="file-input" accept=".svg,.png,.jpg,.jpeg,.gif"
                                    aria-describedby="surat_perintah_penangkapan_help">
                            </label>
                            <div class="file-name" id="surat_perintah_penangkapan_name"></div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500" id="surat_perintah_penangkapan_help">
                            File yang diunggah akan digunakan sebagai dokumen pendukung laporan.
                        </p>
                    </div>

                    <!-- Kronologis -->
                    <div>
                        <label for="kronologis" class="block text-sm font-medium text-gray-700">
                            Kronologis Kejadian
                        </label>
                        <textarea id="kronologis" name="kronologis" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Tuliskan kronologis kejadian secara detail..."></textarea>
                    </div>

                    <!-- Data Tersangka -->
                    <div>
                        <label for="data_tersangka_id" class="block text-sm font-medium text-gray-700">
                            Data Tersangka
                        </label>
                        <select id="data_tersangka_id" name="data_tersangka_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Tersangka --</option>
                            <option value="1">Tersangka 001</option>
                            <option value="2">Tersangka 002</option>
                            <option value="3">Tersangka 003</option>
                        </select>
                    </div>

                    <!-- Laporan Polisi -->
                    <div>
                        <label for="laporan_polisi" class="block text-sm font-medium text-gray-700">
                            Laporan Polisi
                        </label>
                        <div class="file-input-container">
                            <label for="laporan_polisi" class="file-input-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <span class="mt-2 text-sm text-gray-500">Klik untuk upload atau seret file ke
                                    sini</span>
                                <span class="mt-1 text-xs text-gray-400">SVG, PNG, JPG, atau GIF (Maks.
                                    800x400px)</span>
                                <input type="file" name="laporan_polisi" id="laporan_polisi" class="file-input"
                                    accept=".svg,.png,.jpg,.jpeg,.gif" aria-describedby="laporan_polisi_help">
                            </label>
                            <div class="file-name" id="laporan_polisi_name"></div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500" id="laporan_polisi_help">
                            File yang diunggah akan digunakan sebagai dokumen pendukung laporan.
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status
                        </label>
                        <select id="status" name="status"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="draft">Draft</option>
                            <option value="diajukan">Diajukan</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-5 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="button"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle file inputs to show file name
            const fileInputs = document.querySelectorAll('.file-input');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || '';
                    const fileNameElement = document.getElementById(`${input.id}_name`);
                    if (fileNameElement) {
                        if (fileName) {
                            fileNameElement.innerHTML = `
                                <div class="flex items-center mt-2 text-sm text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>${fileName}</span>
                                </div>
                            `;

                            // Change label style when file is selected
                            const label = input.closest('.file-input-label');
                            if (label) {
                                label.style.borderColor = '#8b5cf6';
                                label.style.backgroundColor = '#f5f3ff';
                            }
                        } else {
                            fileNameElement.textContent = '';

                            // Reset label style
                            const label = input.closest('.file-input-label');
                            if (label) {
                                label.style.borderColor = '#e5e7eb';
                                label.style.backgroundColor = '';
                            }
                        }
                    }
                });
            });
        });
    </script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'94c7d50857efff86',t:'MTc0OTM3OTg2Ny4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>

</body>

</html>
