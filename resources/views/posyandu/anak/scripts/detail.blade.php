<script>
// Print Detail
function printDetail() {
    window.print();
}

// Export to PDF (future implementation)
function exportToPDF() {
    showToast('info', 'Fitur export PDF akan segera hadir');
}

// Keyboard shortcuts
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + P: Print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            printDetail();
        }
        
        // Ctrl/Cmd + E: Edit
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            window.location.href = "{{ route('posyandu.anak.edit', $anak->id_anak) }}";
        }
        
        // Ctrl/Cmd + I: Input pengukuran
        if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
            e.preventDefault();
            window.location.href = "{{ route('posyandu.pengukuran.form', ['id_anak' => $anak->id_anak]) }}";
        }
        
        // Escape: Back to index
        if (e.key === 'Escape') {
            if (confirm('Kembali ke daftar anak?')) {
                window.location.href = "{{ route('posyandu.anak.index') }}";
            }
        }
    });

    // Fade-in animations
    const sections = document.querySelectorAll('.space-y-6 > div');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        setTimeout(() => {
            section.style.transition = 'all 0.5s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Toast notification system
function showToast(type, message) {
    const colors = {
        info: 'bg-blue-600',
        success: 'bg-green-600',
        warning: 'bg-orange-600',
        error: 'bg-red-600'
    };
    
    const icons = {
        info: 'fa-info-circle',
        success: 'fa-check-circle',
        warning: 'fa-exclamation-triangle',
        error: 'fa-times-circle'
    };
    
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl transform translate-x-full transition-transform duration-300 z-50 max-w-md`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icons[type]} text-xl mr-3"></i>
            <div class="flex-1">${message}</div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 10);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(full)';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Print styles
const printStyles = `
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        nav, header, .back-button, button, .no-print {
            display: none !important;
        }
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = printStyles;
document.head.appendChild(styleSheet);
</script>