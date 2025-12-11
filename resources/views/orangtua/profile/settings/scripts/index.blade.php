<script>
// Delete account modal
function showDeleteAccountModal() {
    document.getElementById('deleteAccountModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteAccountModal() {
    document.getElementById('deleteAccountModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Form submission
document.addEventListener('DOMContentLoaded', function() {
    const settingsForm = document.getElementById('settingsForm');
    const deleteAccountForm = document.getElementById('deleteAccountForm');
    
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            showLoadingOverlay('Menyimpan pengaturan...');
        });
    }
    
    if (deleteAccountForm) {
        deleteAccountForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Apakah Anda benar-benar yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')) {
                this.submit();
            }
        });
    }
    
    // Animate elements
    animateSettings();
    
    // Track changes
    trackSettingsChanges();
});

// Show loading overlay
function showLoadingOverlay(message = 'Memproses...') {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    overlay.innerHTML = `
        <div class="bg-white rounded-2xl p-8 text-center shadow-2xl max-w-md">
            <div class="w-20 h-20 border-4 border-purple-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-xl font-bold text-gray-800 mb-2">${message}</p>
            <p class="text-sm text-gray-600">Mohon tunggu sebentar</p>
        </div>
    `;
    document.body.appendChild(overlay);
}

// Animate settings sections
function animateSettings() {
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
}

// Track settings changes
function trackSettingsChanges() {
    const form = document.getElementById('settingsForm');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    let originalValues = {};
    
    // Store original values
    inputs.forEach(input => {
        if (input.type === 'checkbox') {
            originalValues[input.name] = input.checked;
        } else {
            originalValues[input.name] = input.value;
        }
    });
    
    // Check for changes
    let hasChanges = false;
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            const currentValue = this.type === 'checkbox' ? this.checked : this.value;
            if (currentValue !== originalValues[this.name]) {
                hasChanges = true;
                showUnsavedChangesWarning();
            }
        });
    });
}

// Show unsaved changes warning
function showUnsavedChangesWarning() {
    const warning = document.getElementById('unsavedChangesWarning');
    if (!warning) {
        const div = document.createElement('div');
        div.id = 'unsavedChangesWarning';
        div.className = 'fixed bottom-4 left-4 bg-orange-500 text-white px-6 py-4 rounded-lg shadow-2xl z-50 animate-slide-up';
        div.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                <p class="font-medium">Anda memiliki perubahan yang belum disimpan</p>
            </div>
        `;
        document.body.appendChild(div);
    }
}

// Close modal on outside click
document.getElementById('deleteAccountModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteAccountModal();
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape: Close modal
    if (e.key === 'Escape') {
        const modal = document.getElementById('deleteAccountModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeDeleteAccountModal();
        }
    }
    
    // Ctrl/Cmd + S: Save settings
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('settingsForm')?.dispatchEvent(new Event('submit'));
    }
});

// Smooth scroll to section
function scrollToSection(sectionId) {
    document.getElementById(sectionId)?.scrollIntoView({ behavior: 'smooth' });
}

console.log('%c⚙️ Settings Module', 'font-size: 16px; font-weight: bold; color: #9333ea;');
</script>

<style>
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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-slide-up {
    animation: slideUp 0.3s ease-out;
}

.animate-scale-in {
    animation: scaleIn 0.3s ease-out;
}

/* Checkbox custom styling */
input[type="checkbox"]:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
}

/* Radio custom styling */
input[type="radio"]:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
}
</style>