@php
    $bgClass = 'bg-[#000878]'; // Default Blue
    $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'; // Info
    
    if ($notifikasi->tipe_notifikasi === 'Peringatan') {
        $bgClass = 'bg-red-600';
        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
    } elseif ($notifikasi->tipe_notifikasi === 'Validasi') {
        $bgClass = 'bg-green-600';
        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
    }
@endphp

<div class="{{ $bgClass }} px-8 py-6 text-white">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-5">
            {{-- Icon --}}
            <div class="flex-shrink-0 mt-1">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $icon !!}
                    </svg>
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-2.5 py-0.5 bg-white/20 rounded text-xs font-bold uppercase tracking-wide border border-white/10">
                        {{ $notifikasi->tipe_notifikasi }}
                    </span>
                    @if($notifikasi->status_baca === 'Belum Dibaca')
                    <span class="px-2.5 py-0.5 bg-yellow-400 text-yellow-900 rounded text-xs font-bold shadow-sm">
                        BARU
                    </span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold mb-1">{{ $notifikasi->judul }}</h1>
                <p class="text-sm text-blue-100/90 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') }} WIB
                </p>
            </div>
        </div>

        {{-- Status Badge --}}
        @if($notifikasi->status_baca === 'Sudah Dibaca')
        <div class="hidden md:flex items-center bg-white/10 px-3 py-1.5 rounded-lg border border-white/10">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-xs font-medium">Dibaca</span>
        </div>
        @endif
    </div>
</div>