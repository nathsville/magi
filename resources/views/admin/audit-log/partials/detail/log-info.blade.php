{{-- Header Card --}}
<div class="bg-gradient-to-r from-{{ $log->action_color }}-500 to-{{ $log->action_color }}-600 px-6 py-5">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->action_icon }}"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">{{ $log->action }}</h2>
                <p class="text-{{ $log->action_color }}-100 text-sm mt-1">{{ $log->module }} Activity</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-white/80 text-xs">Log ID</p>
            <p class="text-white font-mono text-lg">#{{ $log->id_audit }}</p>
        </div>
    </div>
</div>