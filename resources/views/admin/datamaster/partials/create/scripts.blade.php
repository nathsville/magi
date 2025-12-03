@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('datamasterForm');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const tipe = document.getElementById('tipe_data').value;
        const kode = document.getElementById('kode').value.trim();
        const nilai = document.getElementById('nilai').value.trim();
        
        if (!tipe || !kode || !nilai) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi',
                confirmButtonColor: '#000878'
            });
            return false;
        }

        // Show loading
        Swal.fire({
            title: 'Menyimpan Data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
});
</script>
@endpush