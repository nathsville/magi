<script>
// Form submission with confirmation
document.getElementById('formLaporan').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const jenis = document.querySelector('input[name="jenis_laporan"]:checked');
    const bulan = document.querySelector('select[name="periode_bulan"]');
    const tahun = document.querySelector('select[name="periode_tahun"]');
    
    if (!jenis || !bulan.value || !tahun.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Form Belum Lengkap',
            text: 'Mohon lengkapi semua field yang diperlukan',
            confirmButtonColor: '#000878'
        });
        return;
    }
    
    const bulanText = bulan.options[bulan.selectedIndex].text;
    const tahunText = tahun.value;
    
    Swal.fire({
        title: 'Generate Laporan?',
        html: `Anda akan membuat <strong>${jenis.value}</strong><br>untuk periode <strong>${bulanText} ${tahunText}</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#000878',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Generate',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnSubmit').innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Generating...</span>
            `;
            
            this.submit();
        }
    });
});

// Optional: AJAX Preview when period is selected
const bulanSelect = document.querySelector('select[name="periode_bulan"]');
const tahunSelect = document.querySelector('select[name="periode_tahun"]');

function loadPreview() {
    const bulan = bulanSelect.value;
    const tahun = tahunSelect.value;
    
    if (bulan && tahun) {
        // Show preview section
        document.getElementById('previewSection').style.display = 'block';
        
        // AJAX call to get preview data
        fetch(`{{ route('puskesmas.laporan.preview-data') }}?bulan=${bulan}&tahun=${tahun}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('previewTotalAnak').textContent = data.total_anak || 0;
            document.getElementById('previewNormal').textContent = data.total_normal || 0;
            document.getElementById('previewStunting').textContent = data.total_stunting || 0;
        })
        .catch(error => {
            console.error('Error loading preview:', error);
            document.getElementById('previewSection').style.display = 'none';
        });
    } else {
        document.getElementById('previewSection').style.display = 'none';
    }
}

bulanSelect.addEventListener('change', loadPreview);
tahunSelect.addEventListener('change', loadPreview);

// Load preview on page load if values exist
window.addEventListener('load', function() {
    if (bulanSelect.value && tahunSelect.value) {
        loadPreview();
    }
});
</script>