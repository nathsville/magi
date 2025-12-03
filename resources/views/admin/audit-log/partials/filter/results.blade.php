@if(isset($logs))
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">Hasil Pencarian</h2>
        <span class="text-sm text-gray-600">{{ $logs->total() }} hasil ditemukan</span>
    </div>

    @if($logs->count() > 0)
    <div class="divide-y divide-gray-200">
        @foreach($logs as $log)
        <div class="p-6 hover:bg-gray-50 transition cursor-pointer" onclick="showLogDetail({{ $log->id_audit }})">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-{{ $log->action_color }}-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-{{ $log->action_color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->action_icon }}"></path>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $log->action_color }}-100 text-{{ $log->action_color }}-800">
                                    {{ $log->action }}
                                </span>
                                <span class="text-xs text-gray-500">•</span>
                                <span class="text-xs font-medium text-gray-700">{{ $log->module }}</span>
                            </div>
                            <p class="text-sm text-gray-900">{{ $log->description }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 mt-2">
                        <div class="flex items-center text-xs text-gray-600">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $log->user?->nama ?? 'System' }}</span>
                        </div>
                        <span class="text-gray-400">•</span>
                        <div class="flex items-center text-xs text-gray-600">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $log->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $logs->links() }}
    </div>
    @endif

    @else
    <div class="p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Hasil</h3>
        <p class="text-sm text-gray-600">Coba ubah filter pencarian Anda</p>
    </div>
    @endif
</div>
@endif