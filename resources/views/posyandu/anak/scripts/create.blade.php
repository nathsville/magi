<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    
    // NIK validation (16 digits)
    const nikInput = document.querySelector('input[name="nik_anak"]');
    if (nikInput) {
        nikInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').substring(0, 16);
            
            if (this.value.length === 16) {
                this.classList.remove('border-red-500');
                this.classList.add('border-green-500');
            } else {
                this.classList.remove('border-green-500');
            }
        });
        
        nikInput.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    }

    // Nama validation (letters only)
    const namaInput = document.querySelector('input[name="nama_anak"]');
    if (namaInput) {
        namaInput.addEventListener('input', function(e) {
            // Capitalize first letter of each word
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        });
    }

    // Date validation
    const dateInput = document.querySelector('input[name="tanggal_lahir"]');
    if (dateInput) {
        dateInput.addEventListener('change', function() {
            const birthDate = new Date(this.value);
            const today = new Date();
            const age = Math.floor((today - birthDate) / (365.25 * 24 * 60 * 60 * 1000));
            
            if (age > 10) {
                showToast('warning', 'Peringatan: Anak berusia lebih dari 10 tahun. Pastikan tanggal lahir sudah benar.');
            } else if (age < 0) {
                showToast('error', 'Tanggal lahir tidak valid!');
                this.value = '';
            } else {
                showToast('info', `Usia anak: ${age} tahun (${Math.floor(age * 12)} bulan)`);
            }
        });
    }

    // Radio button styling
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove styling from all labels in this group
            const name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
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

    // Form validation before submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return false;
        }
        
        // Show loading overlay
        showLoadingOverlay();
        
        // Submit form
        this.submit();
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S: Submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
        
        // Escape: Cancel
        if (e.key === 'Escape') {
            if (confirm('Batalkan pendaftaran anak?')) {
                window.location.href = "{{ route('posyandu.anak.index') }}";
            }
        }
    });
});

function validateForm() {
    let isValid = true;
    const errors = [];

    // Validate NIK
    const nik = document.querySelector('input[name="nik_anak"]').value;
    if (nik.length !== 16) {
        errors.push('NIK harus 16 digit');
        isValid = false;
    }

    // Validate Nama
    const nama = document.querySelector('input[name="nama_anak"]').value;
    if (nama.trim().length < 3) {
        errors.push('Nama anak minimal 3 karakter');
        isValid = false;
    }

    // Validate Jenis Kelamin
    const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked');
    if (!jenisKelamin) {
        errors.push('Pilih jenis kelamin');
        isValid = false;
    }

    // Validate Tanggal Lahir
    const tanggalLahir = document.querySelector('input[name="tanggal_lahir"]').value;
    if (!tanggalLahir) {
        errors.push('Tanggal lahir wajib diisi');
        isValid = false;
    }

    // Validate Anak Ke
    const anakKe = document.querySelector('input[name="anak_ke"]').value;
    if (anakKe < 1 || anakKe > 20) {
        errors.push('Anak ke harus antara 1-20');
        isValid = false;
    }

    // Validate Orang Tua
    const orangTua = document.querySelector('select[name="id_orangtua"]').value;
    if (!orangTua) {
        errors.push('Pilih orang tua');
        isValid = false;
    }

    if (!isValid) {
        showToast('error', errors.join('<br>'));
        
        // Scroll to first error
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    return isValid;
}

function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.innerHTML = `
        <div class="bg-white rounded-2xl p-8 text-center shadow-2xl">
            <div class="w-16 h-16 border-4 border-teal-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-xl font-bold text-gray-800 mb-2">Menyimpan Data...</p>
            <p class="text-sm text-gray-600">Mohon tunggu sebentar</p>
        </div>
    `;
    document.body.appendChild(overlay);
}

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
</script>