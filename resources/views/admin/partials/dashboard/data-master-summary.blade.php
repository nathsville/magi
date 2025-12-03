<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Ringkasan Data Master</h3>
            <p class="text-xs text-gray-500 mt-1">Status data referensi sistem</p>
        </div>
        <a href="{{ route('admin.datamaster') }}" class="text-sm text-primary hover:text-blue-700 font-medium flex items-center space-x-1">
            <span>Kelola</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        {{-- Kriteria Stunting --}}
        <div onclick="window.location='{{ route('admin.datamaster') }}?tipe=Kriteria Stunting'" class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\DataMaster::where('tipe_data', 'Kriteria Stunting')->count() }}</p>
            <p class="text-xs text-gray-600 mt-1">Kriteria Stunting</p>
        </div>

        {{-- Status Gizi --}}
        <div onclick="window.location='{{ route('admin.datamaster') }}?tipe=Status Gizi'" class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\DataMaster::where('tipe_data', 'Status Gizi')->count() }}</p>
            <p class="text-xs text-gray-600 mt-1">Status Gizi</p>
        </div>

        {{-- Jenis Laporan --}}
        <div onclick="window.location='{{ route('admin.datamaster') }}?tipe=Jenis Laporan'" class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\DataMaster::where('tipe_data', 'Jenis Laporan')->count() }}</p>
            <p class="text-xs text-gray-600 mt-1">Jenis Laporan</p>
        </div>

        {{-- Total Pengguna --}}
        <div onclick="window.location='{{ route('admin.users') }}'" class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
            <p class="text-xs text-gray-600 mt-1">Total Pengguna</p>
        </div>
    </div>

    {{-- Warning Box --}}
    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <p class="text-sm font-medium text-yellow-800">Perhatian Data Master</p>
                <p class="text-xs text-yellow-700 mt-1">Pastikan data master selalu ter-update untuk akurasi perhitungan Z-Score dan status gizi anak.</p>
            </div>
        </div>
    </div>
</div>