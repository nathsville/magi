<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 text-[#000878] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Kalender
        </h3>
    </div>

    <div class="p-6">
        {{-- Month & Year Header --}}
        <div class="flex items-center justify-between mb-4">
            <button onclick="changeMonth(-1)" 
                class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <h4 class="text-base font-semibold text-gray-900" id="currentMonthYear">
                {{ now()->isoFormat('MMMM YYYY') }}
            </h4>
            <button onclick="changeMonth(1)" 
                class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        {{-- Weekday Headers --}}
        <div class="grid grid-cols-7 gap-1 mb-2">
            @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                <div class="text-center text-xs font-semibold text-gray-600 py-2">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-1" id="calendarGrid">
            {{-- Will be populated by JavaScript --}}
        </div>

        {{-- Legend --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-[#000878] rounded-full"></span>
                    <span class="text-gray-600">Hari ini</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-red-100 rounded-full border border-red-300"></span>
                    <span class="text-gray-600">Ada event</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Info --}}
    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-t border-blue-200">
        <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-xs text-blue-800">
                <p class="font-semibold mb-1">Periode Pelaporan Bulan Ini:</p>
                <p>{{ now()->startOfMonth()->format('d M Y') }} - {{ now()->endOfMonth()->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentDate = new Date();

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Update header
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    document.getElementById('currentMonthYear').textContent = `${monthNames[month]} ${year}`;
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    
    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';
    
    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        const cell = document.createElement('div');
        cell.className = 'text-center py-2';
        grid.appendChild(cell);
    }
    
    // Days of month
    for (let day = 1; day <= daysInMonth; day++) {
        const cell = document.createElement('div');
        const isToday = day === today.getDate() && 
                       month === today.getMonth() && 
                       year === today.getFullYear();
        
        // Sample: Mark day 10, 20, 30 as event days
        const hasEvent = day % 10 === 0;
        
        cell.className = `text-center py-2 text-sm font-medium rounded-lg cursor-pointer transition
            ${isToday ? 'bg-[#000878] text-white shadow-md' : 'text-gray-700 hover:bg-gray-100'}
            ${hasEvent && !isToday ? 'bg-red-50 border border-red-200' : ''}`;
        
        cell.textContent = day;
        cell.onclick = () => showDayInfo(day, month, year);
        
        grid.appendChild(cell);
    }
}

function changeMonth(delta) {
    currentDate.setMonth(currentDate.getMonth() + delta);
    renderCalendar();
}

function showDayInfo(day, month, year) {
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    Swal.fire({
        title: `${day} ${monthNames[month]} ${year}`,
        html: `
            <div class="text-left text-sm space-y-2">
                <p class="text-gray-600">Belum ada kegiatan terjadwal pada tanggal ini.</p>
                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-800">
                        <strong>Tips:</strong> Anda dapat menambahkan pengingat untuk validasi data atau kegiatan monitoring.
                    </p>
                </div>
            </div>
        `,
        icon: 'info',
        confirmButtonColor: '#000878',
        confirmButtonText: 'Tutup'
    });
}

// Initialize calendar on page load
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
});
</script>
@endpush