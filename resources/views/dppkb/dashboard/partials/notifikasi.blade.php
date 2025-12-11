<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 text-[#000878] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                Notifikasi
            </h3>
            @if($notifikasi->count() > 0)
                <button onclick="markAllAsRead()" 
                    class="text-xs font-medium text-[#000878] hover:text-blue-900 transition flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tandai Semua Dibaca
                </button>
            @endif
        </div>
    </div>

    <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
        @forelse($notifikasi as $notif)
            <div class="p-4 hover:bg-gray-50 transition cursor-pointer group" 
                 onclick="openNotification({{ $notif->id_notifikasi }})">
                <div class="flex items-start space-x-3">
                    {{-- Icon based on type --}}
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center
                        {{ $notif->tipe_notifikasi === 'Validasi' ? 'bg-purple-100' : '' }}
                        {{ $notif->tipe_notifikasi === 'Peringatan' ? 'bg-red-100' : '' }}
                        {{ $notif->tipe_notifikasi === 'Informasi' ? 'bg-blue-100' : '' }}">
                        @if($notif->tipe_notifikasi === 'Validasi')
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($notif->tipe_notifikasi === 'Peringatan')
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 group-hover:text-[#000878] transition truncate">
                            {{ $notif->judul }}
                        </p>
                        <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                            {{ Str::limit($notif->pesan, 100) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $notif->tanggal_kirim->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Unread indicator --}}
                    @if($notif->status_baca === 'Belum Dibaca')
                        <div class="flex-shrink-0">
                            <span class="inline-block w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-sm text-gray-500 font-medium">Tidak ada notifikasi baru</p>
                <p class="text-xs text-gray-400 mt-1">Semua notifikasi sudah dibaca</p>
            </div>
        @endforelse
    </div>

    @if($notifikasi->count() > 0)
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('dppkb.notifikasi') }}" 
                class="text-sm font-medium text-[#000878] hover:text-blue-900 flex items-center justify-center group">
                <span>Lihat Semua Notifikasi</span>
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function openNotification(id) {
    // Mark as read
    fetch(`{{ route('dppkb.notifikasi.read', ':id') }}`.replace(':id', id), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        // Redirect to notification detail
        window.location.href = `{{ route('dppkb.notifikasi') }}`;
    });
}

function markAllAsRead() {
    Swal.fire({
        title: 'Tandai Semua Dibaca?',
        text: 'Semua notifikasi akan ditandai sebagai sudah dibaca',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#000878',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Tandai Semua',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route('dppkb.notifikasi.read-all') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Semua notifikasi telah ditandai dibaca',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
}
</script>
@endpush