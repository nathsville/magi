<script>
// Form submission with loading overlay
document.getElementById('laporanForm').addEventListener('submit', function(e) {
    showLoadingOverlay();
});

// Radio button styling
document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('input[type="radio"][name="format"]');
    
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove styling from all labels
            document.querySelectorAll('input[type="radio"][name="format"]').forEach(r => {
                const label = r.closest('label');
                if (label) {
                    label.classList.remove('border-teal-500', 'bg-teal-50');
                    label.classList.add('border-gray-300');
                }
            });
            
            // Add styling to selected label
            const label = this.closest('label');
            if (label) {
                label.classList.remove('border-gray-300');
                label.classList.add('border-teal-500', 'bg-teal-50');
            }
        });
    });

    // Apply initial styling to checked radio
    const checkedRadio = document.querySelector('input[type="radio"][name="format"]:checked');
    if (checkedRadio) {
        const label = checkedRadio.closest('label');
        if (label) {
            label.classList.remove('border-gray-300');
            label.classList.add('border-teal-500', 'bg-teal-50');
        }
    }

    // Fade-in animation for cards
    animateCards();

    // Initialize tooltips
    initTooltips();

    // Keyboard shortcuts
    initKeyboardShortcuts();

    // Auto-select current month/year on first load
    if (!sessionStorage.getItem('laporanVisited')) {
        sessionStorage.setItem('laporanVisited', 'true');
        showToast('info', 'Pilih bulan dan tahun untuk membuat laporan');
    }
});

// Show loading overlay
function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.innerHTML = `
        <div class="bg-white rounded-2xl p-8 text-center shadow-2xl max-w-md">
            <div class="w-20 h-20 border-4 border-teal-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-xl font-bold text-gray-800 mb-2">Membuat Laporan...</p>
            <p class="text-sm text-gray-600 mb-4">Mohon tunggu, sedang memproses data</p>
            <div class="flex items-center justify-center space-x-2">
                <div class="w-2 h-2 bg-teal-600 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                <div class="w-2 h-2 bg-teal-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-teal-600 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
            </div>
        </div>
    `;
    document.body.appendChild(overlay);
}

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
        <div class="flex items-start">
            <i class="fas ${icons[type]} text-xl mr-3 mt-1"></i>
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
    }, 5000);
}

// Animate cards on load
function animateCards() {
    const cards = document.querySelectorAll('.grid > div, .space-y-6 > div');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Initialize tooltips
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute bg-gray-800 text-white text-xs px-3 py-2 rounded shadow-lg z-50';
            tooltip.textContent = tooltipText;
            tooltip.style.bottom = '100%';
            tooltip.style.left = '50%';
            tooltip.style.transform = 'translateX(-50%) translateY(-8px)';
            tooltip.style.whiteSpace = 'nowrap';
            
            this.style.position = 'relative';
            this.appendChild(tooltip);
            
            // Add arrow
            const arrow = document.createElement('div');
            arrow.className = 'absolute w-0 h-0';
            arrow.style.borderLeft = '4px solid transparent';
            arrow.style.borderRight = '4px solid transparent';
            arrow.style.borderTop = '4px solid #1f2937';
            arrow.style.bottom = '-4px';
            arrow.style.left = '50%';
            arrow.style.transform = 'translateX(-50%)';
            tooltip.appendChild(arrow);
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.absolute');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
}

// Keyboard shortcuts
function initKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + G: Generate laporan
        if ((e.ctrlKey || e.metaKey) && e.key === 'g') {
            e.preventDefault();
            document.getElementById('laporanForm').dispatchEvent(new Event('submit'));
        }
        
        // Ctrl/Cmd + P: Select PDF format
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            const pdfRadio = document.querySelector('input[type="radio"][value="pdf"]');
            if (pdfRadio) {
                pdfRadio.checked = true;
                pdfRadio.dispatchEvent(new Event('change'));
            }
        }
        
        // Ctrl/Cmd + E: Select Excel format
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            const excelRadio = document.querySelector('input[type="radio"][value="excel"]');
            if (excelRadio) {
                excelRadio.checked = true;
                excelRadio.dispatchEvent(new Event('change'));
            }
        }
        
        // Escape: Back to dashboard
        if (e.key === 'Escape') {
            if (confirm('Kembali ke dashboard?')) {
                window.location.href = "{{ route('posyandu.dashboard') }}";
            }
        }
    });
}

// Form validation
function validateLaporanForm() {
    const bulan = document.querySelector('select[name="bulan"]').value;
    const tahun = document.querySelector('select[name="tahun"]').value;
    const format = document.querySelector('input[name="format"]:checked');
    
    if (!bulan || !tahun) {
        showToast('error', 'Pilih bulan dan tahun terlebih dahulu');
        return false;
    }
    
    if (!format) {
        showToast('error', 'Pilih format laporan');
        return false;
    }
    
    return true;
}

// Quick report download (from quick reports section)
function quickDownload(bulan, tahun, format) {
    showLoadingOverlay();
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('posyandu.laporan.generate') }}";
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    const bulanInput = document.createElement('input');
    bulanInput.type = 'hidden';
    bulanInput.name = 'bulan';
    bulanInput.value = bulan;
    
    const tahunInput = document.createElement('input');
    tahunInput.type = 'hidden';
    tahunInput.name = 'tahun';
    tahunInput.value = tahun;
    
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'format';
    formatInput.value = format;
    
    form.appendChild(csrfInput);
    form.appendChild(bulanInput);
    form.appendChild(tahunInput);
    form.appendChild(formatInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Month name helper
function getMonthName(month) {
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return months[month - 1] || '';
}

// Show keyboard shortcuts help
function showShortcutsHelp() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-keyboard text-teal-600 mr-2"></i>Keyboard Shortcuts
                </h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-700">Generate Laporan</span>
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs font-mono">Ctrl+G</kbd>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-700">Pilih Format PDF</span>
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs font-mono">Ctrl+P</kbd>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-700">Pilih Format Excel</span>
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs font-mono">Ctrl+E</kbd>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-700">Kembali ke Dashboard</span>
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs font-mono">Esc</kbd>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-700">Lihat Shortcuts</span>
                    <kbd class="px-2 py-1 bg-gray-100 rounded text-xs font-mono">?</kbd>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    // Close on click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

// Show shortcuts help on ? key
document.addEventListener('keypress', function(e) {
    if (e.key === '?') {
        showShortcutsHelp();
    }
});

// Add floating help button
document.addEventListener('DOMContentLoaded', function() {
    const helpButton = document.createElement('button');
    helpButton.className = 'fixed bottom-6 right-6 w-14 h-14 bg-teal-600 text-white rounded-full shadow-2xl hover:bg-teal-700 transition transform hover:scale-110 z-40';
    helpButton.innerHTML = '<i class="fas fa-question text-xl"></i>';
    helpButton.onclick = showShortcutsHelp;
    helpButton.setAttribute('data-tooltip', 'Keyboard Shortcuts (?)');
    document.body.appendChild(helpButton);
});

// Statistics animation
function animateStats() {
    const statNumbers = document.querySelectorAll('.text-4xl.font-bold, .text-2xl.font-bold');
    
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent) || 0;
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 30);
        const duration = 1000;
        const stepTime = duration / 30;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            stat.textContent = currentValue;
        }, stepTime);
    });
}

// Call animate stats on load
window.addEventListener('load', function() {
    setTimeout(animateStats, 500);
});

// Progress bar animation for breakdown
document.addEventListener('DOMContentLoaded', function() {
    const progressBars = document.querySelectorAll('.bg-gradient-to-r');
    
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-out';
            bar.style.width = width;
        }, 300);
    });
});

// Auto-save form state to localStorage
function saveFormState() {
    const bulan = document.querySelector('select[name="bulan"]').value;
    const tahun = document.querySelector('select[name="tahun"]').value;
    const format = document.querySelector('input[name="format"]:checked')?.value;
    
    localStorage.setItem('laporan_form_state', JSON.stringify({
        bulan,
        tahun,
        format
    }));
}

// Restore form state from localStorage
function restoreFormState() {
    const savedState = localStorage.getItem('laporan_form_state');
    if (savedState) {
        const state = JSON.parse(savedState);
        
        if (state.bulan) {
            document.querySelector('select[name="bulan"]').value = state.bulan;
        }
        if (state.tahun) {
            document.querySelector('select[name="tahun"]').value = state.tahun;
        }
        if (state.format) {
            const formatRadio = document.querySelector(`input[name="format"][value="${state.format}"]`);
            if (formatRadio) {
                formatRadio.checked = true;
                formatRadio.dispatchEvent(new Event('change'));
            }
        }
    }
}

// Auto-save on form change
document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('#laporanForm select, #laporanForm input[type="radio"]');
    formInputs.forEach(input => {
        input.addEventListener('change', saveFormState);
    });
    
    // Restore on load
    restoreFormState();
});

// Print helper function
function printSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (!section) return;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #0d9488; color: white; }
            </style>
        </head>
        <body>
            ${section.innerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Console easter egg
console.log('%c🏥 MaGi System', 'font-size: 20px; font-weight: bold; color: #0d9488;');
console.log('%cLaporan Posyandu Module', 'font-size: 14px; color: #0891b2;');
console.log('%cPress ? for keyboard shortcuts', 'font-size: 12px; color: #64748b;');
</script>

<style>
/* Additional styles for animations */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.animate-slide-up {
    animation: slideUp 0.5s ease-out;
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-in;
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
    background: #0d9488;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #0891b2;
}

/* Focus styles */
select:focus,
input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
}

/* Button hover effects */
button {
    transition: all 0.3s ease;
}

button:active {
    transform: scale(0.98);
}

/* Loading spinner animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Bounce animation for loading dots */
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-bounce {
    animation: bounce 1s infinite;
}

/* Keyboard shortcut badge styles */
kbd {
    font-family: 'Courier New', monospace;
    border: 1px solid #cbd5e1;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Floating button pulse */
@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(13, 148, 136, 0);
    }
}

.fixed.bottom-6.right-6 {
    animation: pulse 2s infinite;
}
</style>