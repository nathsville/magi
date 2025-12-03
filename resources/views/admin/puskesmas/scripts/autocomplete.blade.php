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
        // Safe check
        const val = searchInput.value || "";
        if (val.length > 0) {
            clearSearch.classList.remove('hidden');
        } else {
            clearSearch.classList.add('hidden');
        }
    }

    function highlightMatch(text, query) {
        if (!query) return text;
        // Escape special chars in query just in case
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
            const url = new URL('{{ route("admin.puskesmas.search") }}', window.location.origin);
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
        
        // Group by 'kecamatan' (Agar rapi per wilayah)
        // Jika data JSON tidak punya kecamatan, fallback ke 'Lainnya'
        const grouped = suggestions.reduce((acc, item) => {
            const groupKey = item.kecamatan || 'Lainnya';
            if (!acc[groupKey]) {
                acc[groupKey] = [];
            }
            acc[groupKey].push(item);
            return acc;
        }, {});

        Object.keys(grouped).forEach((kecamatan, index) => {
            if (index > 0) {
                html += '<div class="border-t border-gray-100 my-1"></div>';
            }
            
            // Header Group (Nama Kecamatan)
            html += `
                <div class="px-3 py-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Kec. ${kecamatan}
                </div>
            `;

            grouped[kecamatan].forEach(item => {
                const statusColor = item.status === 'Aktif' ? 'green' : 'red';
                // Highlight Nama Puskesmas
                const highlight = highlightMatch(item.nama_puskesmas, (searchInput.value || "").trim());
                
                // HTML Item Puskesmas
                html += `
                    <div class="suggestion-item px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-2 border-transparent hover:border-primary transition-colors"
                         data-nama="${item.nama_puskesmas}"
                         onclick="selectSuggestion('${item.nama_puskesmas}')">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">${highlight}</span>
                                </div>
                                ${item.alamat ? `<p class="text-xs text-gray-500 mt-1 line-clamp-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> ${item.alamat}</p>` : ''}
                            </div>
                            <span class="px-2 py-0.5 bg-${statusColor}-100 text-${statusColor}-700 text-[10px] font-bold uppercase rounded-full ml-3 tracking-wide">${item.status}</span>
                        </div>
                    </div>
                `;
            });
        });

        html += '</div>';
        
        // Footer Suggestion
        html += `
            <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-between">
                <span>${suggestions.length} Puskesmas ditemukan</span>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-sm font-medium">Data Puskesmas tidak ditemukan</p>
                <p class="text-xs text-gray-400 mt-1">Pastikan ejaan nama benar</p>
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

    function selectSuggestion(namaPuskesmas) {
        // Masukkan nama puskesmas ke input
        searchInput.value = namaPuskesmas;
        suggestionDropdown.classList.add('hidden');
        
        // Submit form filter/pencarian
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
        // Input event (Safe 'this' context fix applied)
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
                e.preventDefault(); // Prevent default form submit
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

    // Initialize state
    toggleClearButton();
</script>