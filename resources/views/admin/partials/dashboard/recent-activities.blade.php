<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
            <p class="text-xs text-gray-500 mt-1">Log aktivitas sistem dalam 24 jam terakhir</p>
        </div>
        <a href="{{ route('admin.audit-log') }}" class="text-sm text-primary hover:text-blue-700 font-medium">Lihat Semua</a>
    </div>

    <div class="space-y-4">
        @php
            $activities = [
                ['user' => 'Admin Sistem', 'action' => 'Menambahkan data master baru', 'time' => '2 menit yang lalu', 'icon' => 'plus', 'color' => 'blue'],
                ['user' => 'Petugas Posyandu Melati', 'action' => 'Input data pengukuran 5 anak', 'time' => '15 menit yang lalu', 'icon' => 'upload', 'color' => 'green'],
                ['user' => 'Petugas Puskesmas Lumpue', 'action' => 'Validasi 12 data stunting', 'time' => '1 jam yang lalu', 'icon' => 'check', 'color' => 'purple'],
                ['user' => 'Sistem', 'action' => 'Mengirim notifikasi ke 8 orang tua', 'time' => '2 jam yang lalu', 'icon' => 'bell', 'color' => 'orange'],
                ['user' => 'Admin Sistem', 'action' => 'Mengubah data Posyandu Anggrek', 'time' => '3 jam yang lalu', 'icon' => 'edit', 'color' => 'indigo'],
            ];
        @endphp

        @foreach($activities as $activity)
        <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
            <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                @if($activity['icon'] == 'plus')
                    <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                @elseif($activity['icon'] == 'upload')
                    <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                @elseif($activity['icon'] == 'check')
                    <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($activity['icon'] == 'bell')
                    <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">{{ $activity['user'] }}</p>
                <p class="text-sm text-gray-600">{{ $activity['action'] }}</p>
                <p class="text-xs text-gray-400 mt-1 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $activity['time'] }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>