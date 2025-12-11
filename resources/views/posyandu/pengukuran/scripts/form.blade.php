<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============= FORM VALIDATION =============
    const form = document.getElementById('measurementForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Show loading overlay
            showLoadingOverlay();
        });
    }

    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate Berat Badan
        const beratBadan = parseFloat(document.querySelector('input[name="berat_badan"]')?.value);
        if (isNaN(beratBadan) || beratBadan < 1 || beratBadan > 50) {
            errors.push('Berat badan harus antara 1-50 kg');
            isValid = false;
        }

        // Validate Tinggi Badan
        const tinggiBadan = parseFloat(document.querySelector('input[name="tinggi_badan"]')?.value);
        if (isNaN(tinggiBadan) || tinggiBadan < 30 || tinggiBadan > 150) {
            errors.push('Tinggi badan harus antara 30-150 cm');
            isValid = false;
        }

        // Validate Lingkar Kepala
        const lingkarKepala = parseFloat(document.querySelector('input[name="lingkar_kepala"]')?.value);
        if (isNaN(lingkarKepala) || lingkarKepala < 20 || lingkarKepala > 70) {
            errors.push('Lingkar kepala harus antara 20-70 cm');
            isValid = false;
        }

        // Validate Lingkar Lengan
        const lingkarLengan = parseFloat(document.querySelector('input[name="lingkar_lengan"]')?.value);
        if (isNaN(lingkarLengan) || lingkarLengan < 5 || lingkarLengan > 40) {
            errors.push('Lingkar lengan harus antara 5-40 cm');
            isValid = false;
        }

        // Validate Cara Ukur
        const caraUkur = document.querySelector('input[name="cara_ukur"]:checked');
        if (!caraUkur) {
            errors.push('Pilih cara ukur tinggi badan');
            isValid = false;
        }

        if (!isValid) {
            showToast(errors.join(', '), 'error');
        }

        return isValid;
    }

    // ============= AUTO-FILL HELPER =============
    
    // Auto-suggest cara ukur based on age
    const tanggalLahir = "{{ $anak->tanggal_lahir ?? '' }}";
    const tanggalUkurInput = document.querySelector('input[name="tanggal_ukur"]');
    
    if (tanggalLahir && tanggalUkurInput) {
        tanggalUkurInput.addEventListener('change', function() {
            const umurTahun = calculateAge(tanggalLahir, this.value);
            const caraUkurRadios = document.querySelectorAll('input[name="cara_ukur"]');
            
            if (umurTahun < 2) {
                caraUkurRadios[0].checked = true; // Terlentang
                showToast('Cara ukur otomatis dipilih: Terlentang (anak < 2 tahun)', 'info');
            } else {
                caraUkurRadios[1].checked = true; // Berdiri
                showToast('Cara ukur otomatis dipilih: Berdiri (anak ≥ 2 tahun)', 'info');
            }
        });
    }

    function calculateAge(birthDate, measureDate) {
        const birth = new Date(birthDate);
        const measure = new Date(measureDate);
        const diffTime = Math.abs(measure - birth);
        const diffYears = diffTime / (1000 * 60 * 60 * 24 * 365.25);
        return diffYears;
    }

    // ============= REAL-TIME INPUT VALIDATION =============
    
    const numericInputs = document.querySelectorAll('input[type="number"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = parseFloat(this.value);
            const min = parseFloat(this.min);
            const max = parseFloat(this.max);
            
            if (value < min) {
                this.classList.add('border-red-500');
                this.classList.remove('border-gray-300');
            } else if (value > max) {
                this.classList.add('border-red-500');
                this.classList.remove('border-gray-300');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-green-500');
                setTimeout(() => {
                    this.classList.remove('border-green-500');
                    this.classList.add('border-gray-300');
                }, 1000);
            }
        });

        // Prevent negative values
        input.addEventListener('keydown', function(e) {
            if (e.key === '-' || e.key === 'e' || e.key === 'E') {
                e.preventDefault();
            }
        });
    });

    // ============= KEYBOARD SHORTCUTS =============
    
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            if (form) {
                form.submit();
            }
        }

        // Escape to cancel
        if (e.key === 'Escape') {
            if (confirm('Batalkan input dan kembali ke dashboard?')) {
                window.location.href = "{{ route('posyandu.dashboard') }}";
            }
        }
    });

    // ============= RADIO BUTTON STYLING =============
    
    const radioLabels = document.querySelectorAll('label:has(input[type="radio"])');
    radioLabels.forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        
        radio.addEventListener('change', function() {
            radioLabels.forEach(l => {
                l.classList.remove('border-teal-500', 'bg-teal-50');
                l.classList.add('border-gray-300');
            });
            
            if (this.checked) {
                label.classList.add('border-teal-500', 'bg-teal-50');
                label.classList.remove('border-gray-300');
            }
        });
    });

    // ============= CHARACTER COUNTER =============
    
    const textarea = document.querySelector('textarea[name="catatan"]');
    if (textarea) {
        const maxLength = textarea.getAttribute('maxlength');
        const counterDiv = document.createElement('div');
        counterDiv.className = 'text-xs text-gray-500 mt-1 text-right';
        counterDiv.textContent = `0 / ${maxLength} karakter`;
        textarea.parentNode.insertBefore(counterDiv, textarea.nextSibling.nextSibling);

        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            counterDiv.textContent = `${currentLength} / ${maxLength} karakter`;
            
            if (currentLength >= maxLength) {
                counterDiv.classList.add('text-red-500', 'font-bold');
            } else {
                counterDiv.classList.remove('text-red-500', 'font-bold');
            }
        });
    }

    // ============= AUTO-DISMISS ALERTS =============
    
    setTimeout(() => {
        const alerts = document.querySelectorAll('[id$="Alert"]');
        alerts.forEach(alert => {
            if (alert.id !== 'warningAlert') { // Don't auto-dismiss warning
                alert.classList.add('animate-slideUp');
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);

    // ============= HELPER FUNCTIONS =============
    
    function showToast(message, type = 'info') {
        const colors = {
            'info': 'bg-blue-500',
            'success': 'bg-green-500',
            'warning': 'bg-orange-500',
            'error': 'bg-red-500'
        };

        const icons = {
            'info': 'fa-info-circle',
            'success': 'fa-check-circle',
            'warning': 'fa-exclamation-triangle',
            'error': 'fa-times-circle'
        };

        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl z-50 animate-slideUp max-w-md`;
        toast.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas ${icons[type]} text-xl"></i>
                <span class="font-medium">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('animate-slideUp');
            toast.classList.add('animate-slideDown');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    function showLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        overlay.innerHTML = `
            <div class="bg-white rounded-2xl p-8 text-center shadow-2xl">
                <div class="w-16 h-16 border-4 border-teal-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                <p class="text-gray-800 font-bold text-lg">Menyimpan Data...</p>
                <p class="text-gray-600 text-sm mt-2">Sedang menghitung Z-Score</p>
            </div>
        `;
        document.body.appendChild(overlay);
    }
});

// ============= ANIMATION STYLES =============
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
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }

    /* Prevent zoom on mobile input focus */
    @media screen and (max-width: 768px) {
        input[type="number"],
        input[type="date"],
        textarea {
            font-size: 16px !important;
        }
    }
`;
document.head.appendChild(style);
</script>