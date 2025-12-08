<script>
/**
 * Clear all filters and reload page
 */
function clearFilters() {
    window.location.href = "{{ route('orangtua.edukasi.index') }}";
}

/**
 * Auto-submit form on category change
 */
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll to content after filter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('kategori') || urlParams.has('search')) {
        setTimeout(() => {
            document.querySelector('.grid')?.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    }

    // Search input live validation
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            if (e.target.value.length > 100) {
                e.target.value = e.target.value.substring(0, 100);
                showToast('Pencarian maksimal 100 karakter', 'warning');
            }
        });
    }

    // Enter key to submit search
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    }
});

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    const colors = {
        'info': 'bg-blue-500',
        'success': 'bg-green-500',
        'warning': 'bg-orange-500',
        'error': 'bg-red-500'
    };

    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slideDown`;
    toast.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas fa-info-circle"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('animate-slideUp');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    
    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>