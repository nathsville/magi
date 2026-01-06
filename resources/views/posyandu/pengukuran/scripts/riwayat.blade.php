<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Riwayat Pengukuran Loaded');
    });

    /**
     * Membersihkan semua filter pencarian
     * Dipanggil oleh tombol Reset di search-filter-riwayat.blade.php
     */
    function clearFilters() {
        // Redirect ke route base untuk menghapus semua query parameters
        window.location.href = "{{ route('posyandu.pengukuran.riwayat') }}";
    }

    /**
     * Export data ke Excel
     * Dipanggil oleh tombol Export Excel di riwayat.blade.php
     */
    function exportToExcel() {
        // Ambil parameter pencarian saat ini dari URL
        const searchParams = new URLSearchParams(window.location.search);
        
        // Tambahkan parameter export (sesuaikan dengan logika di controller Anda)
        searchParams.set('action', 'export_excel'); 
        
        // Buat URL tujuan export
        // Menggunakan route yang sama tapi dengan parameter tambahan
        const exportUrl = "{{ route('posyandu.pengukuran.riwayat') }}?" + searchParams.toString();
        
        // Arahkan window ke URL tersebut untuk memicu download
        window.location.href = exportUrl;
    }
</script>