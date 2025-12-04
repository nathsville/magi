<script>
// Load anak data from hidden div
const anakDataElement = document.getElementById('anakData');
const allAnakData = anakDataElement ? JSON.parse(anakDataElement.dataset.anak) : [];

// Filter anak by posyandu
function filterAnakByPosyandu() {
    const posyanduId = document.getElementById('id_posyandu').value;
    const anakSelect = document.getElementById('id_anak');
    
    if (!posyanduId) {
        anakSelect.disabled = true;
        anakSelect.innerHTML = '<option value="">Pilih posyandu terlebih dahulu</option>';
        document.getElementById('anakInfo').classList.add('hidden');
        return;
    }
    
    // Filter anak by posyandu
    const filteredAnak = allAnakData.filter(anak => anak.id_posyandu == posyanduId);
    
    // Populate select
    anakSelect.disabled = false;
    anakSelect.innerHTML = '<option value="">Pilih anak...</option>';
    
    filteredAnak.forEach(anak => {
        const option = document.createElement('option');
        option.value = anak.id_anak;
        option.textContent = `${anak.nama_anak} (${anak.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'})`;
        option.dataset.anak = JSON.stringify(anak);
        anakSelect.appendChild(option);
    });
    
    if (filteredAnak.length === 0) {
        anakSelect.innerHTML = '<option value="">Tidak ada anak terdaftar di posyandu ini</option>';
        anakSelect.disabled = true;
    }
}

// Load anak info when selected
function loadAnakInfo() {
    const anakSelect = document.getElementById('id_anak');
    const selectedOption = anakSelect.options[anakSelect.selectedIndex];
    
    if (!selectedOption.dataset.anak) {
        document.getElementById('anakInfo').classList.add('hidden');
        return;
    }
    
    const anakData = JSON.parse(selectedOption.dataset.anak);
    
    // Calculate age in months and years
    const birthDate = new Date(anakData.tanggal_lahir);
    const today = new Date();
    const ageInMonths = (today.getFullYear() - birthDate.getFullYear()) * 12 + 
                        (today.getMonth() - birthDate.getMonth());
    const ageYears = Math.floor(ageInMonths / 12);
    const ageMonths = ageInMonths % 12;
    
    // Format tanggal lahir
    const formattedDate = new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    }).format(birthDate);
    
    // Update info display
    document.getElementById('infoJK').textContent = 
        anakData.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    document.getElementById('infoTglLahir').textContent = formattedDate;
    document.getElementById('infoUmur').textContent = 
        `${ageYears} tahun ${ageMonths} bulan (${ageInMonths} bulan)`;
    document.getElementById('infoOrangTua').textContent = anakData.nama_orangtua || '-';
    
    // Show info card with animation
    const infoCard = document.getElementById('anakInfo');
    infoCard.classList.remove('hidden');
    infoCard.classList.add('animate-fadeIn');
    
    // Auto-determine cara_ukur based on age
    const caraUkurInput = document.getElementById('cara_ukur');
    if (ageInMonths < 24) {
        caraUkurInput.value = 'Berbaring';
    } else {
        caraUkurInput.value = 'Berdiri';
    }
    
    // Store anak data for later use
    anakSelect.dataset.selectedAnak = JSON.stringify({
        ...anakData,
        umur_bulan: ageInMonths,
        umur_tahun: ageYears,
        cara_ukur: caraUkurInput.value
    });
    
    // Trigger age-based outlier check if measurements already filled
    setTimeout(() => {
        checkOutlierByAge();
    }, 100);
}

function getSelectedAnakInfo() {
    const anakSelect = document.getElementById('id_anak');
    if (!anakSelect.dataset.selectedAnak) return null;
    return JSON.parse(anakSelect.dataset.selectedAnak);
}

// Auto-calculate umur_bulan on tanggal_ukur change
document.getElementById('tanggal_ukur')?.addEventListener('change', function() {
    const anakInfo = getSelectedAnakInfo();
    if (!anakInfo) return;
    
    const birthDate = new Date(anakInfo.tanggal_lahir);
    const measureDate = new Date(this.value);
    
    const ageInMonths = (measureDate.getFullYear() - birthDate.getFullYear()) * 12 + 
                        (measureDate.getMonth() - birthDate.getMonth());
    
    // Update stored data
    anakInfo.umur_bulan = ageInMonths;
    document.getElementById('id_anak').dataset.selectedAnak = JSON.stringify(anakInfo);
    
    // Update display
    const ageYears = Math.floor(ageInMonths / 12);
    const ageMonths = ageInMonths % 12;
    document.getElementById('infoUmur').textContent = 
        `${ageYears} tahun ${ageMonths} bulan (${ageInMonths} bulan)`;
    
    // Re-check outliers with new age
    checkOutlierByAge();
});

// CSS for fade-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>