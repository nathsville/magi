<script>
    // ==================== CONFIGURATION ====================
    const searchConfig = {
        minChars: 2,
        debounceTime: 300,
        maxResults: 10
    };

    // ==================== DOM ELEMENTS ====================
    const searchInput = document.getElementById('searchInput');
    const suggestionDropdown = document.getElementById('suggestionDropdown');
    const clearSearch = document.getElementById('clearSearch');
    const searchLoading = document.getElementById('searchLoading');
    const tipeFilter = document.getElementById('tipeFilter');

    let debounceTimer;
    let currentFocus = -1;

    // ==================== UTILITY FUNCTIONS ====================
    
    function debounce(func, wait) {
        return function executedFunction(...args) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func(...args), wait);
        };
    }

    function toggleClearButton() {
        if (searchInput.value.length > 0) {
            clearSearch.classList.remove('hidden');
        } else {
            clearSearch.classList.add('hidden');
        }
    }

    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
    }

    // ==================== FETCH & DISPLAY ====================

    async function fetchSuggestions(query, tipe = '') {
        if (query.length < searchConfig.minChars) {
            suggestionDropdown.innerHTML = '';
            suggestionDropdown.classList.add('hidden');
            return;
        }

        searchLoading.classList.remove('hidden');
        clearSearch.classList.add('hidden');

        try {
            const url = new URL('{{ route("admin.datamaster.search") }}', window.location.origin);
            url.searchParams.append('q', query);
            if (tipe) url.searchParams.append('tipe', tipe);

            const response = await fetch(url);
            const data = await response.json();

            displaySuggestions(data);
        } catch (error) {
            console.error('Error fetching suggestions:', error);
            showError();
        } finally {
            searchLoading.classList.add('hidden');
            toggleClearButton();
        }
    }

    function displaySuggestions(suggestions) {
        currentFocus = -1;

        if (suggestions.length === 0) {
            showEmptyState();
            return;
        }

        let html = '<div class="py-2">';
        
        // Group by tipe_data
        const grouped = suggestions.reduce((acc, item) => {
            if (!acc[item.tipe_data]) {
                acc[item.tipe_data] = [];
            }
            acc[item.tipe_data].push(item);
            return acc;
        }, {});

        Object.keys(grouped).forEach((tipe, index) => {
            if (index > 0) {
                html += '<div class="border-t border-gray-100 my-1"></div>';
            }
            
            html += `
                <div class="px-3 py-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    ${tipe}
                </div>
            `;

            grouped[tipe].forEach(item => {
                const statusColor = item.status === 'Aktif' ? 'green' : 'red';
                const highlight = highlightMatch(item.kode + ' - ' + item.nilai, searchInput.value);
                
                html += `
                    <div class="suggestion-item px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-2 border-transparent hover:border-primary transition-colors"
                         data-kode="${item.kode}"
                         data-nilai="${item.nilai}"
                         onclick="selectSuggestion('${item.kode}', '${item.nilai}')">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <code class="text-xs font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-700">${item.kode}</code>
                                    <span class="text-sm font-medium text-gray-900">${highlight}</span>
                                </div>
                                ${item.deskripsi ? `<p class="text-xs text-gray-500 mt-1 line-clamp-1">${item.deskripsi}</p>` : ''}
                            </div>
                            <span class="px-2 py-0.5 bg-${statusColor}-100 text-${statusColor}-700 text-xs rounded-full ml-3">${item.status}</span>
                        </div>
                    </div>
                `;
            });
        });

        html += '</div>';
        html += `
            <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-between">
                <span>Menampilkan ${suggestions.length} hasil</span>
                <span class="text-primary">Tekan Enter untuk semua hasil</span>
            </div>
        `;

        suggestionDropdown.innerHTML = html;
        suggestionDropdown.classList.remove('hidden');
    }

    function showEmptyState() {
        suggestionDropdown.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm">Tidak ada hasil yang ditemukan</p>
                <p class="text-xs text-gray-400 mt-1">Coba kata kunci lain</p>
            </div>
        `;
        suggestionDropdown.classList.remove('hidden');
    }

    function showError() {
        suggestionDropdown.innerHTML = `
            <div class="p-4 text-center text-red-500">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm">Terjadi kesalahan</p>
                <p class="text-xs text-gray-400 mt-1">Silakan coba lagi</p>
            </div>
        `;
        suggestionDropdown.classList.remove('hidden');
    }

    // ==================== ACTIONS ====================

    function selectSuggestion(kode, nilai) {
        searchInput.value = kode + ' - ' + nilai;
        suggestionDropdown.classList.add('hidden');
        document.getElementById('searchForm').submit();
    }

    // ==================== KEYBOARD NAVIGATION ====================

    function addActive(items) {
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        if (items[currentFocus]) {
            items[currentFocus].classList.add('bg-blue-50', 'border-primary');
            items[currentFocus].scrollIntoView({ block: 'nearest' });
        }
    }

    function removeActive(items) {
        items.forEach(item => {
            item.classList.remove('bg-blue-50', 'border-primary');
        });
    }

    // ==================== EVENT LISTENERS ====================

    if (searchInput && tipeFilter) {
        // Input event
        searchInput.addEventListener('input', debounce(function() {
            const query = (searchInput.value || "").trim();
            const tipe = tipeFilter.value;
            fetchSuggestions(query, tipe);
        }, searchConfig.debounceTime));

        // Filter change
        tipeFilter.addEventListener('change', function() {
            const query = (searchInput.value || "").trim();
            if (query.length >= searchConfig.minChars) {
                fetchSuggestions(query, this.value);
            }
        });

        // Clear search
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            suggestionDropdown.innerHTML = '';
            suggestionDropdown.classList.add('hidden');
            clearSearch.classList.add('hidden');
            searchInput.focus();
        });

        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = document.querySelectorAll('.suggestion-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentFocus++;
                if (currentFocus >= items.length) currentFocus = 0;
                addActive(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentFocus--;
                if (currentFocus < 0) currentFocus = items.length - 1;
                addActive(items);
            } else if (e.key === 'Enter') {
                if (currentFocus > -1 && items[currentFocus]) {
                    e.preventDefault();
                    items[currentFocus].click();
                }
            } else if (e.key === 'Escape') {
                suggestionDropdown.classList.add('hidden');
            }
        });

        // Click outside to close
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionDropdown.contains(e.target)) {
                suggestionDropdown.classList.add('hidden');
            }
        });
    }

    // Initialize
    toggleClearButton();

    // ==================== DELETE CONFIRMATION ====================

    function confirmDeleteData(button) {
        const form = button.closest('form');
        const kode = button.dataset.kode;
        const nilai = button.dataset.nilai;

        Swal.fire({
            title: 'Hapus Data Master?',
            html: `
                <div class="text-left space-y-2">
                    <p class="text-gray-600">Anda akan menghapus data berikut:</p>
                    <div class="bg-gray-50 rounded-lg p-3 mt-3">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-xs font-semibold text-gray-500">KODE:</span>
                            <code class="text-sm bg-gray-200 px-2 py-1 rounded">${kode}</code>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-semibold text-gray-500">NILAI:</span>
                            <span class="text-sm font-medium">${nilai}</span>
                        </div>
                    </div>
                    <p class="text-red-600 text-sm mt-3">⚠️ Data yang sudah dihapus tidak dapat dikembalikan!</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-medium',
                cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-medium',
                popup: 'rounded-xl'
            },
            width: '500px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    }

    // ==================== FLASH MESSAGES ====================

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#000878',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'OK'
        });
    @endif
</script>