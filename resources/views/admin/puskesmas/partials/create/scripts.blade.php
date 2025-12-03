@push('scripts')
<script>
    // Auto format nomor telepon
    document.getElementById('no_telepon').addEventListener('input', function(e) {
        // Hanya izinkan angka, tanda plus, tanda kurung, dan strip
        this.value = this.value.replace(/[^0-9+\-()]/g, '');
    });

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const nama = document.getElementById('nama_puskesmas').value.trim();
        const alamat = document.getElementById('alamat').value.trim();
        const kecamatan = document.getElementById('kecamatan').value;

        if (!nama || !alamat || !kecamatan) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi (bertanda *)',
                confirmButtonColor: '#000878'
            });
            return false;
        }

        // Show loading
        Swal.fire({
            title: 'Menyimpan Data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@endpush