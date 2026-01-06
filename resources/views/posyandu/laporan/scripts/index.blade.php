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

    // Initialize tooltips
    initTooltips();

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

// Statistics animation
function animateStats() {
    const statNumbers = document.querySelectorAll('.text-4xl.font-bold, .text-2xl.font-bold');
    
    statNumbers.forEach(stat => {
        const originalText = stat.textContent.trim();
        if (!/^\d+$/.test(originalText)) {
            return;
        }

        const finalValue = parseInt(originalText) || 0;
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
</script>

<style>
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
</style>