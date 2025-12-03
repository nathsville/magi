<script>
function showLogDetail(logId) {
    Swal.fire({
        title: 'Loading...',
        text: 'Mengambil detail log',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`/admin/audit-log/${logId}/detail`)
        .then(response => response.json())
        .then(data => {
            const log = data.log;
            
            // Format old and new values
            let changesHTML = '';
            if (log.old_values || log.new_values) {
                changesHTML = '<div class="mt-4 space-y-3">';
                
                if (log.action === 'UPDATE' && log.old_values && log.new_values) {
                    changesHTML += '<h4 class="text-sm font-semibold text-gray-900 mb-2">Perubahan Data:</h4>';
                    changesHTML += '<div class="bg-gray-50 rounded-lg p-3 space-y-2 max-h-60 overflow-y-auto">';
                    
                    const oldValues = JSON.parse(log.old_values);
                    const newValues = JSON.parse(log.new_values);
                    
                    for (const key in newValues) {
                        if (oldValues[key] !== newValues[key] && key !== 'updated_at' && key !== 'created_at') {
                            changesHTML += `
                                <div class="text-xs border-b border-gray-200 pb-2 last:border-0">
                                    <div class="font-medium text-gray-700 mb-1">${key}:</div>
                                    <div class="flex items-start space-x-2">
                                        <div class="flex-1 bg-red-50 border border-red-200 rounded px-2 py-1">
                                            <span class="text-red-700">Sebelum: ${oldValues[key] || '-'}</span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        <div class="flex-1 bg-green-50 border border-green-200 rounded px-2 py-1">
                                            <span class="text-green-700">Sesudah: ${newValues[key] || '-'}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    }
                    changesHTML += '</div>';
                } else if (log.new_values) {
                    changesHTML += '<h4 class="text-sm font-semibold text-gray-900 mb-2">Data:</h4>';
                    changesHTML += '<div class="bg-gray-50 rounded-lg p-3 max-h-60 overflow-y-auto">';
                    changesHTML += '<pre class="text-xs text-gray-700 whitespace-pre-wrap">' + JSON.stringify(JSON.parse(log.new_values), null, 2) + '</pre>';
                    changesHTML += '</div>';
                }
                
                changesHTML += '</div>';
            }

            Swal.fire({
                title: 'Detail Audit Log',
                html: `
                    <div class="text-left space-y-4">
                        <!-- Header Info -->
                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 border border-indigo-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-${getActionColor(log.action)}-100 text-${getActionColor(log.action)}-800">
                                    ${log.action}
                                </span>
                                <span class="text-xs text-indigo-700 font-medium">#${log.id_audit}</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Module:</span>
                                    <span class="font-semibold text-gray-900">${log.module}</span>
                                </div>
                                ${log.record_id ? `
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Record ID:</span>
                                    <span class="font-mono text-xs bg-white px-2 py-1 rounded">${log.record_id}</span>
                                </div>
                                ` : ''}
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Deskripsi:</h4>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <p class="text-sm text-gray-700">${log.description}</p>
                            </div>
                        </div>

                        <!-- User & System Info -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <h4 class="text-xs font-semibold text-gray-600 mb-2">User:</h4>
                                <div class="bg-white border border-gray-200 rounded-lg p-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-indigo-700">${log.user ? log.user.nama.charAt(0) : 'S'}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">${log.user ? log.user.nama : 'System'}</p>
                                            <p class="text-xs text-gray-600">@${log.user ? log.user.username : 'system'}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold text-gray-600 mb-2">Waktu:</h4>
                                <div class="bg-white border border-gray-200 rounded-lg p-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center text-xs text-gray-700">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>${formatDate(log.created_at)}</span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-700">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>${formatTime(log.created_at)}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- IP & User Agent -->
                        <div>
                            <h4 class="text-xs font-semibold text-gray-600 mb-2">Informasi Sistem:</h4>
                            <div class="bg-white border border-gray-200 rounded-lg p-3 space-y-2">
                                <div class="flex items-start text-xs">
                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>IP Address:</strong> ${log.ip_address || 'N/A'}</span>
                                </div>
                                <div class="flex items-start text-xs">
                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700 break-all"><strong>User Agent:</strong> ${log.user_agent || 'N/A'}</span>
                                </div>
                            </div>
                        </div>

                        ${changesHTML}
                    </div>
                `,
                width: '700px',
                showCloseButton: true,
                confirmButtonColor: '#000878',
                confirmButtonText: 'Tutup'
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal mengambil detail log',
                confirmButtonColor: '#000878'
            });
        });
}

function getActionColor(action) {
    const colors = {
        'CREATE': 'green',
        'UPDATE': 'blue',
        'DELETE': 'red',
        'LOGIN': 'purple',
        'LOGOUT': 'gray',
        'VIEW': 'yellow'
    };
    return colors[action] || 'gray';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}

function exportAuditLog() {
    Swal.fire({
        title: 'Export Audit Log',
        html: `
            <div class="text-left space-y-4">
                <p class="text-sm text-gray-600">Anda akan mengekspor semua audit log ke file CSV.</p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <strong>Catatan:</strong>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>File akan diunduh dalam format CSV</li>
                                <li>Gunakan filter lanjutan untuk ekspor data spesifik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#000878',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-download mr-2"></i>Export Sekarang',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("admin.audit-log.export") }}';
            
            showSuccessToast('File sedang diunduh...');
        }
    });
}
</script>