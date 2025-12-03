@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('posyanduForm');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const nama = document.getElementById('nama_posyandu').value.trim();
        const puskesmas = document.getElementById('id_puskesmas').value;
        const alamat = document.getElementById('alamat').value.trim();
        const kelurahan = document.getElementById('kelurahan').value.trim();
        const kecamatan = document.getElementById('kecamatan').value;
        
        if (!nama || !puskesmas || !alamat || !kelurahan || !kecamatan) {
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

    // Flash error messages
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: '<ul class="text-left text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#000878'
        });
    @endif
});
</script>
@endpush