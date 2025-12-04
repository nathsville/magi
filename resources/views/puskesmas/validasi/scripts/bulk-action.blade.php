<script>
// Bulk Selection Handler
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountNumber = document.getElementById('selectedCountNumber');
    
    // Select All functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkUI();
        });
    }
    
    // Individual checkbox change
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkUI();
            
            // Update select all checkbox
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });
    
    // Update bulk action UI
    function updateBulkUI() {
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        
        if (checkedCount > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.classList.remove('hidden');
            selectedCountNumber.textContent = checkedCount;
        } else {
            bulkActions.classList.add('hidden');
            selectedCount.classList.add('hidden');
        }
    }
});

// Bulk Validate Function
function bulkValidate(status) {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    
    if (checkedBoxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak Ada Data Terpilih',
            text: 'Silakan pilih data yang akan divalidasi',
            confirmButtonColor: '#000878'
        });
        return;
    }
    
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    const statusText = status === 'Validated' ? 'memvalidasi' : 'menolak';
    const statusColor = status === 'Validated' ? 'green' : 'red';
    
    Swal.fire({
        title: `${status === 'Validated' ? 'Validasi' : 'Tolak'} ${ids.length} Data?`,
        html: `
            <div class="space-y-4">
                <p class="text-gray-600">
                    Anda akan ${statusText} <span class="font-bold">${ids.length}</span> data pengukuran sekaligus.
                </p>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Pastikan Anda sudah memeriksa semua data dengan teliti sebelum melakukan validasi massal.
                            </p>
                        </div>
                    </div>
                </div>
                <textarea id="bulkCatatanValidasi" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary" 
                    placeholder="Catatan validasi untuk semua data (opsional)" 
                    rows="3"></textarea>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: statusColor === 'green' ? '#16a34a' : '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Ya, ${statusText.charAt(0).toUpperCase() + statusText.slice(1)} Semua`,
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const catatan = document.getElementById('bulkCatatanValidasi').value;
            
            return fetch('/puskesmas/validasi/bulk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ids: ids,
                    status_validasi: status,
                    catatan_validasi: catatan
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: `
                    <p class="text-lg">${result.value.message}</p>
                    <div class="mt-4 p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-800">
                            <span class="font-bold">${result.value.count}</span> data telah ${status === 'Validated' ? 'divalidasi' : 'ditolak'}
                        </p>
                    </div>
                `,
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        }
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + A: Select all
    if ((e.ctrlKey || e.metaKey) && e.key === 'a' && !e.target.matches('input, textarea')) {
        e.preventDefault();
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.dispatchEvent(new Event('change'));
        }
    }
    
    // Escape: Deselect all
    if (e.key === 'Escape') {
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox && selectAllCheckbox.checked) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.dispatchEvent(new Event('change'));
        }
    }
});

// Export selected data (optional feature)
function exportSelected() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    
    if (checkedBoxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak Ada Data Terpilih',
            text: 'Silakan pilih data yang akan diekspor',
            confirmButtonColor: '#000878'
        });
        return;
    }
    
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/puskesmas/validasi/export';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    const idsInput = document.createElement('input');
    idsInput.type = 'hidden';
    idsInput.name = 'ids';
    idsInput.value = JSON.stringify(ids);
    
    form.appendChild(csrfInput);
    form.appendChild(idsInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>