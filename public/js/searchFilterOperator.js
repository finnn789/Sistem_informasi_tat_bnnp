
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const resetButton = document.getElementById('resetFilter');
    const tableBody = document.getElementById('laporanTableBody');
    const loadingIndicator = document.getElementById('loadingIndicator');

    let searchTimeout;

    // Fungsi untuk menampilkan loading
    function showLoading() {
        loadingIndicator.classList.remove('hidden');
    }

    // Fungsi untuk menyembunyikan loading
    function hideLoading() {
        loadingIndicator.classList.add('hidden');
    }

    // Fungsi untuk melakukan filter
    function performFilter() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedStatus = statusFilter.value;
        const selectedDate = dateFilter.value;

        showLoading();

        // Simulasi delay untuk loading (hapus jika menggunakan AJAX)
        setTimeout(() => {
            filterTable(searchTerm, selectedStatus, selectedDate);
            hideLoading();
        }, 300);
    }

    // Fungsi untuk filter tabel secara client-side
    function filterTable(searchTerm, status, dateFilter) {
        const rows = document.querySelectorAll('.laporan-row');
        let visibleCount = 0;

        rows.forEach((row, index) => {
            let shouldShow = true;

            // Filter berdasarkan pencarian
            if (searchTerm) {
                const searchData = row.getAttribute('data-search');
                if (!searchData.includes(searchTerm)) {
                    shouldShow = false;
                }
            }

            // Filter berdasarkan status
            if (status && shouldShow) {
                const statusBadge = row.querySelector('.status-badge');
                const rowStatus = statusBadge.textContent.toLowerCase().trim();
                if (rowStatus !== status) {
                    shouldShow = false;
                }
            }

            // Filter berdasarkan tanggal (implementasi sederhana)
            if (dateFilter && shouldShow) {
                const dateCell = row.children[3].textContent; // Kolom tanggal
                const rowDate = new Date(dateCell);
                const today = new Date();

                switch (dateFilter) {
                    case 'today':
                        if (rowDate.toDateString() !== today.toDateString()) {
                            shouldShow = false;
                        }
                        break;
                    case 'week':
                        const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                        if (rowDate < weekAgo) {
                            shouldShow = false;
                        }
                        break;
                    case 'month':
                        if (rowDate.getMonth() !== today.getMonth() ||
                            rowDate.getFullYear() !== today.getFullYear()) {
                            shouldShow = false;
                        }
                        break;
                    case 'year':
                        if (rowDate.getFullYear() !== today.getFullYear()) {
                            shouldShow = false;
                        }
                        break;
                }
            }

            // Tampilkan atau sembunyikan baris
            if (shouldShow) {
                row.style.display = '';
                visibleCount++;
                // Update nomor urut
                row.children[0].textContent = visibleCount;
            } else {
                row.style.display = 'none';
            }
        });

        // Tampilkan pesan jika tidak ada data
        const noDataRow = document.getElementById('noDataRow');
        if (visibleCount === 0 && !noDataRow) {
            const tbody = document.getElementById('laporanTableBody');
            const newRow = document.createElement('tr');
            newRow.id = 'noDataRowDynamic';
            newRow.innerHTML = `
                <td colspan="6" class="py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium">Tidak ada laporan ditemukan</p>
                        <p class="text-sm">Coba ubah filter pencarian Anda</p>
                    </div>
                </td>
            `;
            tbody.appendChild(newRow);
        } else if (visibleCount > 0) {
            const dynamicNoDataRow = document.getElementById('noDataRowDynamic');
            if (dynamicNoDataRow) {
                dynamicNoDataRow.remove();
            }
        }

        // Update URL tanpa reload halaman
        updateURL(searchTerm, status, dateFilter);
    }

    // Fungsi untuk update URL
    function updateURL(search, status, dateFilter) {
        const url = new URL(window.location);

        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }

        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }

        if (dateFilter) {
            url.searchParams.set('date_filter', dateFilter);
        } else {
            url.searchParams.delete('date_filter');
        }

        window.history.replaceState({}, '', url);
    }

    // Event listeners
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performFilter, 500); // Debounce 500ms
    });

    statusFilter.addEventListener('change', performFilter);
    dateFilter.addEventListener('change', performFilter);

    // Reset filter
    resetButton.addEventListener('click', function () {
        searchInput.value = '';
        statusFilter.value = '';
        dateFilter.value = '';

        // Reset URL
        const url = new URL(window.location);
        url.searchParams.delete('search');
        url.searchParams.delete('status');
        url.searchParams.delete('date_filter');
        window.history.replaceState({}, '', url);

        // Reset tabel
        const rows = document.querySelectorAll('.laporan-row');
        rows.forEach((row, index) => {
            row.style.display = '';
            row.children[0].textContent = index + 1; // Reset nomor urut
        });

        // Hapus pesan no data jika ada
        const dynamicNoDataRow = document.getElementById('noDataRowDynamic');
        if (dynamicNoDataRow) {
            dynamicNoDataRow.remove();
        }
    });

    // Jalankan filter saat halaman dimuat jika ada parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search') || urlParams.has('status') || urlParams.has('date_filter')) {
        performFilter();
    }
});

// Fungsi untuk AJAX (alternatif, jika ingin menggunakan server-side filtering)
function performAjaxFilter() {
    const searchTerm = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;

    showLoading();

    fetch(`${window.location.pathname}?ajax=1&search=${searchTerm}&status=${status}&date_filter=${dateFilter}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('laporanTableBody').innerHTML = data.html;
            hideLoading();
        })
        .catch(error => {
            console.error('Error:', error);
            hideLoading();
        });
}
