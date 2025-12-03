<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- 1. User Information --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Pengguna
        </h3>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            @if($log->user)
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-{{ $log->action_color }}-100 to-{{ $log->action_color }}-50 rounded-full flex items-center justify-center">
                    <span class="text-lg font-bold text-{{ $log->action_color }}-700">
                        {{ substr($log->user->nama, 0, 1) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-base font-semibold text-gray-900 truncate">{{ $log->user->nama }}</p>
                    <p class="text-sm text-gray-600">@{{ $log->user->username }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                        {{ $log->user->role }}
                    </span>
                </div>
            </div>
            @else
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-semibold text-gray-900">System</p>
                    <p class="text-sm text-gray-600">Automated Process</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- 2. Timestamp Information --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Waktu
        </h3>
        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Tanggal:</span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $log->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Jam:</span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $log->created_at->format('H:i:s') }} WIB
                </span>
            </div>
            <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                <span class="text-sm text-gray-600">Relative:</span>
                <span class="text-sm font-medium text-{{ $log->action_color }}-600">
                    {{ $log->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>

    {{-- 3. Module & Record --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Module & Record
        </h3>
        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Module:</span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-semibold bg-indigo-100 text-indigo-800">
                    {{ $log->module }}
                </span>
            </div>
            @if($log->record_id)
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Record ID:</span>
                <span class="font-mono text-sm bg-gray-100 px-2.5 py-1 rounded">
                    {{ $log->record_id }}
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- 4. System Information --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            Informasi Sistem
        </h3>
        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-3">
            <div>
                <p class="text-xs text-gray-500 mb-1">IP Address:</p>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    <span class="text-sm font-mono text-gray-900">{{ $log->ip_address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- User Agent --}}
<div class="mt-6">
    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        User Agent
    </h3>
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <p class="text-sm text-gray-700 break-all font-mono leading-relaxed">
            {{ $log->user_agent ?? 'N/A' }}
        </p>
    </div>
</div>