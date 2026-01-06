<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Detail Pengukuran Loaded');
        
        // Inisialisasi Tooltips (jika menggunakan library seperti Tippy.js atau Bootstrap)
        // initializeTooltips();
    });

    /**
     * Fungsi untuk mencetak halaman
     * Dipanggil oleh tombol di detail-actions.blade.php
     */
    function printPage() {
        window.print();
    }

    /**
     * Fungsi opsional untuk menghapus pengukuran (jika tombol hapus ditambahkan nanti)
     */
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data pengukuran ini? Data yang dihapus tidak dapat dikembalikan.')) {
            // Lakukan submit form delete
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

<style>
    @media print {
        /* Sembunyikan elemen navigasi saat mencetak */
        nav, header, .sidebar, .no-print {
            display: none !important;
        }
        
        /* Atur layout agar pas di kertas */
        body {
            background: white;
            font-size: 12pt;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>