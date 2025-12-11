<script>
// Clear Filters
function clearFilters() {
    window.location.href = "{{ route('posyandu.anak.index') }}";
}

// Auto-submit on Enter key in search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    }

    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.grid > div');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput?.focus();
        }
        
        // Ctrl/Cmd + N: New child registration
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = "{{ route('posyandu.anak.create') }}";
        }
    });
});

// Show tooltip for shortcuts
const shortcutInfo = document.createElement('div');
shortcutInfo.className = 'fixed bottom-4 right-4 bg-gray-800 text-white text-xs px-4 py-2 rounded-lg shadow-lg opacity-0 transition-opacity duration-300';
shortcutInfo.innerHTML = `
    <div class="font-bold mb-1">Keyboard Shortcuts:</div>
    <div>Ctrl/⌘ + K: Cari</div>
    <div>Ctrl/⌘ + N: Daftar Anak Baru</div>
`;
document.body.appendChild(shortcutInfo);

// Show shortcuts on ? key
document.addEventListener('keypress', function(e) {
    if (e.key === '?') {
        shortcutInfo.style.opacity = shortcutInfo.style.opacity === '1' ? '0' : '1';
    }
});
</script>