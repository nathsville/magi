@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== CLOCK UPDATE ====================
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = `${hours}:${minutes} WITA`;
        }
    }
    
    // Update clock every minute
    updateClock();
    setInterval(updateClock, 60000);
    
    // ==================== AUTO REFRESH STATS ====================
    let refreshInterval;
    
    function startAutoRefresh() {
        // Refresh stats every 5 minutes
        refreshInterval = setInterval(() => {
            refreshDashboardStats();
        }, 300000); // 5 minutes
    }
    
    function refreshDashboardStats() {
        console.log('Refreshing dashboard stats...');
        // Optional: Add AJAX call to refresh stats without page reload
        // Uncomment if needed:
        // fetch('{{ route('dppkb.dashboard') }}?ajax=1')
        //     .then(response => response.json())
        //     .then(data => {
        //         // Update stats cards
        //         updateStatsCards(data);
        //     });
    }
    
    // Start auto refresh (optional)
    // startAutoRefresh();
    
    // ==================== SMOOTH SCROLL ====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ==================== TOOLTIPS INITIALIZATION ====================
    // Initialize tooltips if using a library like Tippy.js
    // tippy('[data-tippy-content]', {
    //     placement: 'top',
    //     animation: 'scale'
    // });
    
    // ==================== FLASH MESSAGES ====================
    @if(session('success'))
        showSuccessToast('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showErrorToast('{{ session('error') }}');
    @endif
    
    @if(session('info'))
        showInfoToast('{{ session('info') }}');
    @endif
    
    // ==================== KEYBOARD SHORTCUTS ====================
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K: Quick search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            // Open search modal or focus search input
            console.log('Quick search shortcut');
        }
        
        // Ctrl/Cmd + V: Go to validasi
        if ((e.ctrlKey || e.metaKey) && e.key === 'v') {
            e.preventDefault();
            window.location.href = '{{ route('dppkb.validasi') }}';
        }
        
        // Ctrl/Cmd + M: Go to monitoring
        if ((e.ctrlKey || e.metaKey) && e.key === 'm') {
            e.preventDefault();
            window.location.href = '{{ route('dppkb.monitoring') }}';
        }
    });
    
    // ==================== ANIMATION ON SCROLL ====================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all cards
    document.querySelectorAll('.bg-white.rounded-xl').forEach(el => {
        observer.observe(el);
    });
    
    // ==================== CONSOLE EASTER EGG ====================
    console.log('%c🏛️ MaGi DPPKB Dashboard', 'font-size: 20px; font-weight: bold; color: #000878;');
    console.log('%cExecutive Monitoring System', 'font-size: 14px; color: #6b7280;');
    console.log('%cKeyboard Shortcuts:', 'font-weight: bold; margin-top: 10px;');
    console.log('  Ctrl/Cmd + V → Validasi Final');
    console.log('  Ctrl/Cmd + M → Monitoring');
    console.log('  Ctrl/Cmd + K → Quick Search (coming soon)');
});

// ==================== HELPER FUNCTIONS ====================
function showSuccessToast(message) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

function showErrorToast(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });
}

function showInfoToast(message) {
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

// Export untuk digunakan di partials lain
window.showSuccessToast = showSuccessToast;
window.showErrorToast = showErrorToast;
window.showInfoToast = showInfoToast;
</script>

<style>
/* Custom animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

@keyframes pulse-soft {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-soft {
    animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #000878;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #000660;
}

/* Loading state */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s ease-in-out infinite;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}
</style>
@endpush