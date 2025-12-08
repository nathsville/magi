@php
    $bgClass = 'bg-gradient-to-r from-blue-500 to-blue-600';
    $icon = 'fa-info-circle';
    
    if ($notifikasi->tipe_notifikasi === 'Peringatan') {
        $bgClass = 'bg-gradient-to-r from-orange-500 to-red-500';
        $icon = 'fa-exclamation-triangle';
    } elseif ($notifikasi->tipe_notifikasi === 'Validasi') {
        $bgClass = 'bg-gradient-to-r from-green-500 to-green-600';
        $icon = 'fa-check-circle';
    }
@endphp

<div class="{{ $bgClass }} p-8 text-white">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            {{-- Icon --}}
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas {{ $icon }} text-3xl"></i>
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                        {{ $notifikasi->tipe_notifikasi }}
                    </span>
                    @if($notifikasi->status_baca === 'Belum Dibaca')
                    <span class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-bold">
                        BARU
                    </span>
                    @endif
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $notifikasi->judul }}</h1>
                <p class="text-sm text-white text-opacity-90">
                    <i class="fas fa-clock mr-2"></i>
                    {{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->format('l, d F Y H:i') }} WIB
                </p>
            </div>
        </div>

        {{-- Status Badge --}}
        <div class="flex-shrink-0">
            @if($notifikasi->status_baca === 'Sudah Dibaca')
            <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-xs font-medium backdrop-blur-sm">
                <i class="fas fa-eye mr-1"></i>Sudah Dibaca
            </span>
            @endif
        </div>
    </div>
</div>