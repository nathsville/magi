<script>
document.getElementById('file_pendukung').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    
    if (file) {
        // Validasi ukuran file (max 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 2MB',
                confirmButtonColor: '#000878'
            });
            e.target.value = '';
            filePreview.classList.add('hidden');
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 
                            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Format File Tidak Valid',
                text: 'Hanya menerima file: PDF, JPG, PNG, DOC, DOCX',
                confirmButtonColor: '#000878'
            });
            e.target.value = '';
            filePreview.classList.add('hidden');
            return;
        }
        
        // Tampilkan preview nama file
        fileName.textContent = file.name + ' (' + formatBytes(file.size) + ')';
        filePreview.classList.remove('hidden');
    } else {
        filePreview.classList.add('hidden');
    }
});

function clearFile() {
    document.getElementById('file_pendukung').value = '';
    document.getElementById('filePreview').classList.add('hidden');
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}
</script>