<script>
// Print notification
function printNotification() {
    window.print();
}

// Copy notification content
function copyContent() {
    const content = document.querySelector('.prose').innerText;
    
    navigator.clipboard.writeText(content).then(() => {
        showToast('Konten berhasil disalin', 'success');
    }).catch(err => {
        console.error('Failed to copy:', err);
        showToast('Gagal menyalin konten', 'error');
    });
}

// Share notification (if Web Share API is available)
function shareNotification() {
    const title = '{{ $notifikasi->judul }}';
    const text = '{{ Str::limit($notifikasi->pesan, 100) }}';
    const url = window.location.href;

    if (navigator.share) {
        navigator.share({
            title: title,
            text: text,
            url: url
        }).then(() => {
            console.log('Shared successfully');
        }).catch(err => {
            console.error('Share failed:', err);
        });
    } else {
        // Fallback: Copy link to clipboard
        navigator.clipboard.writeText(url).then(() => {
            showToast('Link berhasil disalin', 'success');
        });
    }
}

// Toast notification (reuse from actions.blade.php)
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

// Print styles
const printStyle = document.createElement('style');
printStyle.textContent = `
    @media print {
        body * {
            visibility: hidden;
        }
        .print-area, .print-area * {
            visibility: visible;
        }
        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        nav, .actions, .related-notifications {
            display: none !important;
        }
    }
`;
document.head.appendChild(printStyle);

// Mark page as print-area
document.querySelector('.container').classList.add('print-area');
</script>