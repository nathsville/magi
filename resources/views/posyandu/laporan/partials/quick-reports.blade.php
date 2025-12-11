<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Laporan Cepat
        </h3>
        <p class="text-xs text-gray-500">6 Bulan Terakhir</p>
    </div>

    @if($availableMonths->isEmpty())
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
            <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="text-sm text-gray-500">Belum ada data laporan</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($availableMonths->take(6) as $month)
            <div class="group bg-white rounded-lg border border-gray-200 p-4 hover:border-blue-400 hover:shadow-md transition duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-sm font-bold text-gray-900">
                            {{ \Carbon\Carbon::create()->month($month->month)->format('F') }} {{ $month->year }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">Bulanan</p>
                    </div>
                    <div class="p-1.5 bg-blue-50 text-[#000878] rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex space-x-2">
                    <form method="POST" action="{{ route('posyandu.laporan.generate') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="bulan" value="{{ $month->month }}">
                        <input type="hidden" name="tahun" value="{{ $month->year }}">
                        <input type="hidden" name="format" value="pdf">
                        <button type="submit" class="w-full flex justify-center items-center px-2 py-1.5 bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded hover:bg-gray-50 transition">
                            <svg class="w-3 h-3 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            PDF
                        </button>
                    </form>

                    <form method="POST" action="{{ route('posyandu.laporan.generate') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="bulan" value="{{ $month->month }}">
                        <input type="hidden" name="tahun" value="{{ $month->year }}">
                        <input type="hidden" name="format" value="excel">
                        <button type="submit" class="w-full flex justify-center items-center px-2 py-1.5 bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded hover:bg-gray-50 transition">
                            <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Excel
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>