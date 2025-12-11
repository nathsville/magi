<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 relative overflow-hidden">
    {{-- Background Accent --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -mr-16 -mt-16"></div>
    
    <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                Selamat Datang, {{ Auth::user()->nama }} 👋
            </h2>
            <div class="flex items-center text-gray-600 text-sm mt-2">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-semibold mr-1">{{ $posyandu->nama_posyandu }}</span>
                </span>
                <span class="mx-2 text-gray-300">|</span>
                <span>{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</span>
            </div>
        </div>

        <div class="hidden md:block text-right">
            <p class="text-sm font-medium text-gray-500">{{ \Carbon\Carbon::now()->isoFormat('dddd') }}</p>
            <p class="text-xl font-bold text-[#000878]">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
            <p class="text-xs text-gray-400 font-mono mt-0.5" id="currentTime"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
    });
    const timeElement = document.getElementById('currentTime');
    if(timeElement) timeElement.textContent = timeString + ' WITA';
}
updateTime();
setInterval(updateTime, 1000);
</script>
@endpush