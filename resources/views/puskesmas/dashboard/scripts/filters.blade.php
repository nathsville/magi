<script>
// Auto-refresh data setiap 5 menit
let refreshInterval;

function startAutoRefresh() {
    refreshInterval = setInterval(() => {
        console.log('Auto-refreshing dashboard data...');
        location.reload();
    }, 300000); // 5 minutes
}

// Stop auto-refresh when user is inactive
let inactivityTimer;
function resetInactivityTimer() {
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(() => {
        clearInterval(refreshInterval);
        console.log('Auto-refresh paused due to inactivity');
    }, 600000); // 10 minutes
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Start auto-refresh
    startAutoRefresh();
    
    // Track user activity
    ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
        document.addEventListener(event, resetInactivityTimer, true);
    });
    
    resetInactivityTimer();
});

// Quick Stats Update (AJAX) - Optional
function updateQuickStats() {
    fetch('{{ route("puskesmas.dashboard") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update stats cards without full page reload
        if (data.success) {
            console.log('Stats updated:', data);
            // Update DOM elements here if needed
        }
    })
    .catch(error => {
        console.error('Error updating stats:', error);
    });
}

// Table Row Click Handler
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('tbody tr[data-posyandu-id]');
    
    tableRows.forEach(row => {
        row.style.cursor = 'pointer';
        
        row.addEventListener('click', function() {
            const posyanduId = this.dataset.posyanduId;
            window.location.href = `/puskesmas/monitoring?posyandu=${posyanduId}`;
        });
    });
});

// Toast Notification Helper
function showToast(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-green-500' : 
                    type === 'error' ? 'bg-red-500' : 
                    type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
    
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-y-20 opacity-0`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-y-20', 'opacity-0');
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Export functionality (if needed)
function exportDashboardData(format = 'pdf') {
    showToast('Mengunduh laporan dashboard...', 'info');
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("puskesmas.laporan.generate") }}';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'format';
    formatInput.value = format;
    
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'jenis_laporan';
    typeInput.value = 'Dashboard Summary';
    
    form.appendChild(csrfInput);
    form.appendChild(formatInput);
    form.appendChild(typeInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Print functionality
function printDashboard() {
    window.print();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R: Refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        location.reload();
    }
    
    // Ctrl/Cmd + P: Print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printDashboard();
    }
    
    // Ctrl/Cmd + F: Focus search (if exists)
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) {
            e.preventDefault();
            searchInput.focus();
        }
    }
});

// Loading state helper
function setLoading(element, loading = true) {
    if (loading) {
        element.classList.add('opacity-50', 'pointer-events-none');
        element.innerHTML = `
            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;
    } else {
        element.classList.remove('opacity-50', 'pointer-events-none');
    }
}

// Check for new notifications
function checkNotifications() {
    fetch('/api/notifications/check', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.hasNew) {
            updateNotificationBadge(data.count);
        }
    })
    .catch(error => {
        console.error('Error checking notifications:', error);
    });
}

function updateNotificationBadge(count) {
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        badge.textContent = count;
        badge.classList.remove('hidden');
    }
}

// Initialize notification checker
setInterval(checkNotifications, 60000); // Check every minute
</script>

{{-- SweetAlert2 for confirmations --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Success message from session
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
@endif

// Error message from session
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session("error") }}',
        confirmButtonColor: '#000878'
    });
@endif
</script>