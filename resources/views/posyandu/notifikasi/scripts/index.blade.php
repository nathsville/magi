<script>
function clearFilters() {
    window.location.href = "{{ route('posyandu.notifikasi') }}";
}

function markAllAsRead() {
    if (confirm('Tandai semua notifikasi sebagai sudah dibaca?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('posyandu.notifikasi.mark-all-as-read') }}";
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteAllRead() {
    if (confirm('Hapus semua notifikasi yang sudah dibaca? Tindakan ini tidak dapat dibatalkan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('posyandu.notifikasi.delete-all-read') }}";
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}

// Fade-in animation
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.space-y-4 > div');
    notifications.forEach((notif, index) => {
        notif.style.opacity = '0';
        notif.style.transform = 'translateY(20px)';
        setTimeout(() => {
            notif.style.transition = 'all 0.5s ease';
            notif.style.opacity = '1';
            notif.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>