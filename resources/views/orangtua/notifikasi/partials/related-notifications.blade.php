@php
    $relatedNotifications = \App\Models\Notifikasi::where('id_user', auth()->id())
        ->where('id_notifikasi', '!=', $notifikasi->id_notifikasi)
        ->where('tipe_notifikasi', $notifikasi->tipe_notifikasi)
        ->orderBy('tanggal_kirim', 'desc')
        ->limit(3)
        ->get();
@endphp

@if($relatedNotifications->isNotEmpty())
<div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fas fa-list text-purple-600 mr-2"></i>Notifikasi Terkait
    </h3>

    <div class="space-y-3">
        @foreach($relatedNotifications as $related)
        <a href="{{ route('orangtua.notifikasi.show', $related->id_notifikasi) }}" 
           class="block p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800 mb-1">{{ $related->judul }}</h4>
                    <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($related->pesan, 80) }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($related->tanggal_kirim)->diffForHumans() }}
                    </p>
                </div>
                <div class="flex-shrink-0 ml-4">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif