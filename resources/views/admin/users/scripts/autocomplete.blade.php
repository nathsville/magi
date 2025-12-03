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
            // Pastikan route ini ada: Route::get('/users/search', ...)->name('admin.users.search');
            const url = new URL('{{ route("admin.users.search") }}', window.location.origin);
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

        // Config Warna Role
        const roleColors = {
            'Admin': 'purple',
            'Petugas Posyandu': 'blue',
            'Petugas Puskesmas': 'green',
            'Petugas DPPKB': 'yellow',
            'Orang Tua': 'pink'
        };

        let html = '<div class="py-2">';
        
        // Grouping berdasarkan Role
        const grouped = suggestions.reduce((acc, item) => {
            const groupKey = item.role || 'Lainnya';
            if (!acc[groupKey]) {
                acc[groupKey] = [];
            }
            acc[groupKey].push(item);
            return acc;
        }, {});

        Object.keys(grouped).forEach((role, index) => {
            if (index > 0) {
                html += '<div class="border-t border-gray-100 my-1"></div>';
            }
            
            // Header Group (Role)
            const color = roleColors[role] || 'gray';
            html += `
                <div class="px-3 py-1.5 text-xs font-semibold text-${color}-600 uppercase tracking-wider bg-${color}-50 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    ${role}
                </div>
            `;

            grouped[role].forEach(item => {
                const statusColor = item.status === 'Aktif' ? 'green' : 'red';
                const highlightName = highlightMatch(item.nama, (searchInput.value || "").trim());
                const highlightUsername = highlightMatch(item.username, (searchInput.value || "").trim());
                
                html += `
                    <div class="suggestion-item px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-2 border-transparent hover:border-primary transition-colors"
                         data-nama="${item.nama}"
                         onclick="selectSuggestion('${item.nama}')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-start gap-3 overflow-hidden">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-700 font-bold text-xs shrink-0">
                                    ${item.nama.charAt(0).toUpperCase()}
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-900 truncate">${highlightName}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1 truncate">
                                        <span class="font-mono text-gray-400">@</span>${highlightUsername}
                                        ${item.email ? `<span class="text-gray-300 mx-1">•</span> ${item.email}` : ''}
                                    </p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-${statusColor}-100 text-${statusColor}-700 text-[10px] font-bold uppercase rounded-full ml-3 tracking-wide shrink-0">${item.status}</span>
                        </div>
                    </div>
                `;
            });
        });

        html += '</div>';
        html += `
            <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-between">
                <span>${suggestions.length} Pengguna ditemukan</span>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="text-sm font-medium">Pengguna tidak ditemukan</p>
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

    function selectSuggestion(nama) {
        searchInput.value = nama;
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
        // Input event
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