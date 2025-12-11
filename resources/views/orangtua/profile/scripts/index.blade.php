<script>
// Password visibility toggle
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength checker
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('newPassword');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
    }
    
    // Fade-in animation
    animateElements();
    
    // Form validation
    initFormValidation();
    
    // NIK validation
    initNIKValidation();
});

// Check password strength
function checkPasswordStrength(password) {
    const strengthDiv = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (!password) {
        strengthDiv.classList.add('hidden');
        return;
    }
    
    strengthDiv.classList.remove('hidden');
    
    let strength = 0;
    let color = '';
    let text = '';
    
    // Length check
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 25;
    
    // Contains lowercase
    if (/[a-z]/.test(password)) strength += 15;
    
    // Contains uppercase
    if (/[A-Z]/.test(password)) strength += 15;
    
    // Contains number
    if (/[0-9]/.test(password)) strength += 10;
    
    // Contains special character
    if (/[^A-Za-z0-9]/.test(password)) strength += 10;
    
    // Set color and text based on strength
    if (strength < 40) {
        color = '#ef4444'; // Red
        text = 'Lemah';
    } else if (strength < 70) {
        color = '#f59e0b'; // Orange
        text = 'Sedang';
    } else if (strength < 90) {
        color = '#10b981'; // Green
        text = 'Kuat';
    } else {
        color = '#06b6d4'; // Cyan
        text = 'Sangat Kuat';
    }
    
    strengthBar.style.width = strength + '%';
    strengthBar.style.backgroundColor = color;
    strengthText.textContent = text;
    strengthText.style.color = color;
}

// Animate elements
function animateElements() {
    const elements = document.querySelectorAll('.space-y-6 > div, .grid > div');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        setTimeout(() => {
            element.style.transition = 'all 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Form validation
function initFormValidation() {
    const profileForm = document.getElementById('profileForm');
    const passwordForm = document.getElementById('passwordForm');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const nik = this.querySelector('input[name="nik"]').value;
            
            if (nik.length !== 16) {
                e.preventDefault();
                showToast('error', 'NIK harus 16 digit');
                return false;
            }
            
            if (!/^\d+$/.test(nik)) {
                e.preventDefault();
                showToast('error', 'NIK harus berupa angka');
                return false;
            }
            
            showLoadingOverlay();
        });
    }
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPassword = this.querySelector('input[name="password"]').value;
            const confirmPassword = this.querySelector('input[name="password_confirmation"]').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                showToast('error', 'Konfirmasi password tidak cocok');
                return false;
            }
            
            if (newPassword.length < 8) {
                e.preventDefault();
                showToast('error', 'Password minimal 8 karakter');
                return false;
            }
            
            showLoadingOverlay();
        });
    }
}

// NIK validation
function initNIKValidation() {
    const nikInput = document.querySelector('input[name="nik"]');
    
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    }
}

// Show loading overlay
function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.innerHTML = `
        <div class="bg-white rounded-2xl p-8 text-center shadow-2xl max-w-md">
            <div class="w-20 h-20 border-4 border-purple-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-xl font-bold text-gray-800 mb-2">Menyimpan...</p>
            <p class="text-sm text-gray-600">Mohon tunggu sebentar</p>
        </div>
    `;
    document.body.appendChild(overlay);
}

// Toast notification
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

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S: Save form
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        const activeForm = document.getElementById('profileForm') || document.getElementById('passwordForm');
        if (activeForm) {
            activeForm.dispatchEvent(new Event('submit'));
        }
    }
    
    // Escape: Back to dashboard
    if (e.key === 'Escape') {
        if (confirm('Kembali ke dashboard?')) {
            window.location.href = "{{ route('orangtua.dashboard') }}";
        }
    }
});

// Console easter egg
console.log('%c👨‍👩‍👧‍👦 MaGi System', 'font-size: 20px; font-weight: bold; color: #9333ea;');
console.log('%cProfile Management Module', 'font-size: 14px; color: #ec4899;');
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
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
    background: #9333ea;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #7e22ce;
}
</style>