<div class="divide-y divide-gray-100">
    <div id="previewModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop transition-opacity duration-300"
            onclick="closeModal()"></div>

        <!-- Modal Dialog -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden animate-scale-in">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <div>
                            <h3 id="modalTitle" class="text-xl font-semibold text-white">Preview File</h3>
                            <p class="text-blue-100 text-sm">File preview dalam modal</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="openFullscreen()"
                            class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition-colors duration-200 text-white">
                            <i class="fas fa-expand"></i>
                        </button>
                        <button onclick="closeModal()"
                            class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition-colors duration-200 text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="relative">
                    <!-- Loading State -->
                    <div id="loadingState" class="absolute inset-0 bg-gray-50 flex items-center justify-center z-10">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin-slow mx-auto mb-4">
                            </div>
                            <p class="text-gray-600 font-medium">Memuat preview file...</p>
                            <p class="text-gray-400 text-sm mt-1">Mohon tunggu sebentar</p>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div id="errorState" class="hidden absolute inset-0 bg-gray-50 items-center justify-center z-10">
                        <div class="text-center max-w-md mx-auto p-6">
                            <div
                                class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-800 mb-2">Gagal memuat preview</h4>
                            <p class="text-gray-600 mb-4">File tidak dapat ditampilkan dalam preview</p>
                            <div class="flex justify-center space-x-3">
                                <button onclick="retryPreview()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                                </button>
                                <button onclick="closeModal()"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Iframe Container -->
                    <div class="h-[70vh] bg-gray-100">
                        <iframe id="previewIframe" class="w-full h-full border-none bg-white" style="display: none;"
                            onload="handleIframeLoad()" onerror="handleIframeError()">
                        </iframe>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <span id="fileInfo" class="text-sm text-gray-600"></span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="downloadFile()"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </button>
                        <button onclick="closeModal()"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let currentFileUrl = '';
    let currentFileName = '';

    function previewFile(fileName, fileUrl) {
        currentFileName = fileName;
        currentFileUrl = fileUrl;

        document.getElementById('previewModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        document.getElementById('modalTitle').textContent = fileName;
        document.getElementById('fileInfo').textContent = `Preview: ${fileName}`;

        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('errorState').classList.add('hidden');
        document.getElementById('previewIframe').style.display = 'none';

        setTimeout(() => {
            document.getElementById('previewIframe').src = fileUrl;
        }, 500);
    }

    function handleIframeLoad() {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('errorState').classList.add('hidden');
        document.getElementById('previewIframe').style.display = 'block';
    }

    function handleIframeError() {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('errorState').classList.remove('hidden');
        document.getElementById('previewIframe').style.display = 'none';
    }

    function retryPreview() {
        document.getElementById('errorState').classList.add('hidden');
        document.getElementById('loadingState').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('previewIframe').src = currentFileUrl + '?retry=' + Date.now();
        }, 300);
    }

    function closeModal() {
        document.getElementById('previewModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('previewIframe').src = '';
        currentFileUrl = '';
        currentFileName = '';
    }

    function openFullscreen() {
        const iframe = document.getElementById('previewIframe');
        if (iframe.requestFullscreen) iframe.requestFullscreen();
        else if (iframe.webkitRequestFullscreen) iframe.webkitRequestFullscreen();
        else if (iframe.mozRequestFullScreen) iframe.mozRequestFullScreen();
        else if (iframe.msRequestFullscreen) iframe.msRequestFullscreen();
    }

    function downloadFile() {
        if (currentFileUrl && currentFileName) {
            const link = document.createElement('a');
            link.href = currentFileUrl;
            link.download = currentFileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>
