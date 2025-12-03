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
    const searchLoading = document.getElementById('loadingSpinner');
    const filterForm = document.getElementById('filterForm');

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
        const val = searchInput.value || "";
        if (val.length > 0) {
            clearSearch.classList.remove('hidden');
        } else {
            clearSearch.classList.add('hidden');
        }
    }

    function highlightMatch(text, query) {
        if (!query) return text;
        const safeQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${safeQuery})`, 'gi');
        return text.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
    }

    // ==================== FETCH & DISPLAY ====================

    async function fetchSuggestions(query) {
        if (query.length < searchConfig.minChars) {
            suggestionDropdown.innerHTML = '';
            suggestionDropdown.classList.add('hidden');
            return;
        }

        if (searchLoading) searchLoading.classList.remove('hidden');
        if (clearSearch) clearSearch.classList.add('hidden');

        try {
            // Pastikan route ini ada: Route::get('/posyandu/search', ...)->name('admin.posyandu.search');
            const url = new URL('{{ route("admin.posyandu.search") }}', window.location.origin);
            url.searchParams.append('q', query);

            const response = await fetch(url);
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            displaySuggestions(data);

        } catch (error) {
            console.error('Error fetching suggestions:', error);
            showError();
        } finally {
            if (searchLoading) searchLoading.classList.add('hidden');
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
        
        // Grouping berdasarkan Nama Puskesmas (Parent)
        const grouped = suggestions.reduce((acc, item) => {
            // Cek jika relasi puskesmas ada, jika tidak masukkan ke 'Lainnya'
            const groupKey = (item.puskesmas && item.puskesmas.nama_puskesmas) 
                             ? item.puskesmas.nama_puskesmas 
                             : 'Lainnya';
            
            if (!acc[groupKey]) {
                acc[groupKey] = [];
            }
            acc[groupKey].push(item);
            return acc;
        }, {});

        Object.keys(grouped).forEach((puskesmasName, index) => {
            if (index > 0) {
                html += '<div class="border-t border-gray-100 my-1"></div>';
            }
            
            // Header Group (Nama Puskesmas)
            html += `
                <div class="px-3 py-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    ${puskesmasName}
                </div>
            `;

            grouped[puskesmasName].forEach(item => {
                const statusColor = item.status === 'Aktif' ? 'green' : 'red';
                const highlight = highlightMatch(item.nama_posyandu, (searchInput.value || "").trim());
                
                // Lokasi detail (Kelurahan, Kecamatan)
                const lokasi = [item.kelurahan, item.kecamatan].filter(Boolean).join(', ');

                html += `
                    <div class="suggestion-item px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-2 border-transparent hover:border-primary transition-colors"
                         data-nama="${item.nama_posyandu}"
                         onclick="selectSuggestion('${item.nama_posyandu}')">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">${highlight}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    ${lokasi}
                                </p>
                            </div>
                            <span class="px-2 py-0.5 bg-${statusColor}-100 text-${statusColor}-700 text-[10px] font-bold uppercase rounded-full ml-3 tracking-wide">${item.status}</span>
                        </div>
                    </div>
                `;
            });
        });

        html += '</div>';
        html += `
            <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-between">
                <span>${suggestions.length} Posyandu ditemukan</span>
                <span class="text-primary hidden sm:inline">Tekan Enter untuk detail</span>
            </div>
        `;

        suggestionDropdown.innerHTML = html;
        suggestionDropdown.classList.remove('hidden');
    }

    function showEmptyState() {
        suggestionDropdown.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">Data Posyandu tidak ditemukan</p>
                <p class="text-xs text-gray-400 mt-1">Coba kata kunci lain</p>
            </div>
        `;
        suggestionDropdown.classList.remove('hidden');
    }

    function showError() {
        suggestionDropdown.innerHTML = `
            <div class="p-4 text-center text-red-500">
                <p class="text-sm font-medium">Gagal memuat data</p>
                <p class="text-xs text-gray-400 mt-1">Periksa koneksi internet</p>
            </div>
        `;
        suggestionDropdown.classList.remove('hidden');
    }

    // ==================== ACTIONS ====================

    function selectSuggestion(namaPosyandu) {
        searchInput.value = namaPosyandu;
        suggestionDropdown.classList.add('hidden');
        
        if(filterForm) {
            filterForm.submit();
        } else {
            searchInput.closest('form').submit();
        }
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

    if (searchInput) {
        // Input event (Safe 'trim' fix applied)
        searchInput.addEventListener('input', debounce(function() {
            const query = (searchInput.value || "").trim();
            
            if (query.length >= searchConfig.minChars) {
                fetchSuggestions(query);
            } else {
                suggestionDropdown.classList.add('hidden');
            }

            toggleClearButton();
        }, searchConfig.debounceTime));

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
                e.preventDefault();
                if (currentFocus > -1 && items[currentFocus]) {
                    items[currentFocus].click();
                } else {
                    if(filterForm) filterForm.submit();
                }
            } else if (e.key === 'Escape') {
                suggestionDropdown.classList.add('hidden');
            }
        });

        // Clear search button
        if(clearSearch) {
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                suggestionDropdown.innerHTML = '';
                suggestionDropdown.classList.add('hidden');
                clearSearch.classList.add('hidden');
                searchInput.focus();
            });
        }

        // Click outside to close
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionDropdown.contains(e.target)) {
                suggestionDropdown.classList.add('hidden');
            }
        });
    }

    // Initialize
    toggleClearButton();
</script>