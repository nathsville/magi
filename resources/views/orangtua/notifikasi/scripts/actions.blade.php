<script>
// Clear filters
function clearFilters() {
    window.location.href = '{{ route('orangtua.notifikasi.index') }}';
}

// Mark as read (AJAX)
async function markAsRead(notifId) {
    try {
        const response = await fetch(`{{ url('orangtua/notifikasi') }}/${notifId}/mark-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            // Update UI
            const badge = document.querySelector(`[data-notif-id="${notifId}"] .unread-badge`);
            if (badge) {
                badge.remove();
            }

            // Update counter
            const counter = document.querySelector('.unread-counter');
            if (counter) {
                const count = parseInt(counter.textContent);
                if (count > 0) {
                    counter.textContent = count - 1;
                }
            }

            // Show toast notification
            showToast('Notifikasi ditandai sebagai dibaca', 'success');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    }
}

// Toast notification
function showToast(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up`;
    toast.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('animate-slide-down');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from { transform: translateY(100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideDown {
        from { transform: translateY(0); opacity: 1; }
        to { transform: translateY(100px); opacity: 0; }
    }
    .animate-slide-up {
        animation: slideUp 0.3s ease-out;
    }
    .animate-slide-down {
        animation: slideDown 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>