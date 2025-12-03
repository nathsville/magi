<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Timeline Aktivitas</span>
        </h2>
    </div>

    <div class="p-6 max-h-[800px] overflow-y-auto">
        @forelse($recentActivities as $date => $logs)
        {{-- Date Header --}}
        <div class="relative mb-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-semibold text-gray-900">
                        @if(\Carbon\Carbon::parse($date)->isToday())
                            Hari Ini
                        @elseif(\Carbon\Carbon::parse($date)->isYesterday())
                            Kemarin
                        @else
                            {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        @endif
                    </h3>
                    <p class="text-xs text-gray-500">{{ $logs->count() }} aktivitas</p>
                </div>
            </div>

            {{-- Timeline Items --}}
            <div class="ml-5 pl-5 border-l-2 border-gray-200 space-y-4">
                @foreach($logs as $log)
                <div class="relative pb-4 group">
                    {{-- Timeline Dot --}}
                    <div class="absolute -left-[26px] top-2 w-3 h-3 bg-{{ $log->action_color }}-500 border-2 border-white rounded-full group-hover:scale-125 transition-transform"></div>

                    {{-- Log Card --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer"
                        onclick="showLogDetail({{ $log->id_audit }})">
                        <div class="flex items-start space-x-3">
                            {{-- Icon --}}
                            <div class="flex-shrink-0 w-10 h-10 bg-{{ $log->action_color }}-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-{{ $log->action_color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->action_icon }}"></path>
                                </svg>
                            </div>

                            {{-- Content --}}
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
                                    <span class="text-xs text-gray-500 ml-4 flex-shrink-0">
                                        {{ $log->created_at->format('H:i') }}
                                    </span>
                                </div>

                                {{-- User Info --}}
                                <div class="flex items-center space-x-3 mt-2">
                                    <div class="flex items-center text-xs text-gray-600">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ $log->user?->nama ?? 'System' }}</span>
                                    </div>
                                    <span class="text-gray-400">•</span>
                                    <div class="flex items-center text-xs text-gray-600">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                        <span>{{ $log->ip_address }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Aktivitas</h3>
            <p class="text-sm text-gray-600">Log aktivitas akan muncul di sini</p>
        </div>
        @endforelse
    </div>

    {{-- View All Button --}}
    @if($recentActivities->count() > 0)
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
        <a href="{{ route('admin.audit-log.filter') }}" 
            class="text-sm font-medium text-[#000878] hover:text-blue-900 flex items-center justify-center space-x-2">
            <span>Lihat Semua Aktivitas</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    @endif
</div>