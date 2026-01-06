<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============= AUTO REFRESH STATS =============
    
    let refreshInterval;
    const enableAutoRefresh = false; // Set to true for production
    
    if (enableAutoRefresh) {
        refreshInterval = setInterval(() => {
            refreshStats();
        }, 60000); // Refresh every 60 seconds
    }

    function refreshStats() {
        fetch("{{ route('posyandu.dashboard.stats') }}", {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            updateStatsCards(data);
            showToast('Data diperbarui', 'success');
        })
        .catch(error => {
            console.error('Error refreshing stats:', error);
        });
    }

    function updateStatsCards(data) {
        // Update today's measurements
        const todayElement = document.querySelector('[data-stat="today"]');
        if (todayElement) {
            todayElement.textContent = data.todayMeasurements;
        }

        // Update monthly measurements
        const monthlyElement = document.querySelector('[data-stat="monthly"]');
        if (monthlyElement) {
            monthlyElement.textContent = data.monthlyMeasurements;
        }

        // Update percentage
        const percentageElement = document.querySelector('[data-stat="percentage"]');
        if (percentageElement) {
            percentageElement.textContent = data.persentaseStunting + '%';
        }
    }

    // ============= NOTIFICATION BADGE PULSE =============
    
    const notifBadge = document.querySelector('.bg-red-500');
    if (notifBadge) {
        setInterval(() => {
            notifBadge.classList.add('animate-ping');
            setTimeout(() => {
                notifBadge.classList.remove('animate-ping');
            }, 1000);
        }, 3000);
    }

    // ============= RECENT MEASUREMENTS HOVER =============
    
    const measurementRows = document.querySelectorAll('tbody tr');
    measurementRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // ============= SMOOTH SCROLL =============
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
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

    // ============= HELPER FUNCTIONS =============
    
    function showToast(message, type = 'info') {
        const colors = {
            'info': 'bg-blue-500',
            'success': 'bg-green-500',
            'warning': 'bg-orange-500',
            'error': 'bg-red-500'
        };

        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slideUp`;
        toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ============= KEYBOARD SHORTCUTS =============
    
    document.addEventListener('keydown', function(e) {
        // Alt + I: Input Pengukuran
        if (e.altKey && e.key === 'i') {
            e.preventDefault();
            window.location.href = "{{ route('posyandu.pengukuran.form') }}";
        }
        
        // Alt + D: Dashboard
        if (e.altKey && e.key === 'd') {
            e.preventDefault();
            window.location.href = "{{ route('posyandu.dashboard') }}";
        }
        
        // Alt + A: Data Anak
        if (e.altKey && e.key === 'a') {
            e.preventDefault();
            window.location.href = "{{ route('posyandu.anak.index') }}";
        }
    });

    // Display keyboard shortcuts hint
    console.log('%c⌨️ Keyboard Shortcuts', 'font-size: 16px; font-weight: bold; color: #14b8a6;');
    console.log('Alt + I: Input Pengukuran');
    console.log('Alt + D: Dashboard');
    console.log('Alt + A: Data Anak');
});
</script>