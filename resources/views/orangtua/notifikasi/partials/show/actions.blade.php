@php
    $relatedNotifications = \App\Models\Notifikasi::where('id_user', auth()->id())
        ->where('id_notifikasi', '!=', $notifikasi->id_notifikasi)
        ->where('tipe_notifikasi', $notifikasi->tipe_notifikasi)
        ->orderBy('tanggal_kirim', 'desc')
        ->limit(3)
        ->get();
@endphp

@if($relatedNotifications->isNotEmpty())
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Notifikasi Serupa
        </h3>
    </div>

    <div class="divide-y divide-gray-100">
        @foreach($relatedNotifications as $related)
        <a href="{{ route('orangtua.notifikasi.show', $related->id_notifikasi) }}" 
           class="block p-4 hover:bg-gray-50 transition group">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-4">
                    <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#000878] transition-colors truncate">
                        {{ $related->judul }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ \Carbon\Carbon::parse($related->tanggal_kirim)->diffForHumans() }}
                    </p>
                </div>
                <div class="flex-shrink-0 text-gray-300 group-hover:text-[#000878] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif