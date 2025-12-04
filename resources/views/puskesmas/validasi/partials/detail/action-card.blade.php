@if($dataStunting->status_validasi === 'Pending')
<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden sticky top-6">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 border-b border-blue-700">
        <h2 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Tindakan Validasi
        </h2>
    </div>
    <div class="p-6 space-y-5">
        <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded-lg border border-blue-100">
            Periksa data di samping. Jika valid, klik tombol <strong>Validasi</strong>. Jika ada kesalahan, klik <strong>Tolak</strong>.
        </p>
        
        <form id="validationForm" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Validasi <span class="font-normal text-gray-400">(Opsional)</span></label>
                <textarea name="catatan_validasi" rows="3" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none"
                    placeholder="Contoh: Data sudah sesuai dengan register posyandu..."></textarea>
            </div>
            
            <div class="grid grid-cols-1 gap-3">
                <button type="button" onclick="validateData('Validated')" 
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-md hover:shadow-lg focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Validasi Data (Valid)
                </button>
                
                <button type="button" onclick="validateData('Rejected')" 
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-red-600 bg-white border-2 border-red-100 rounded-lg hover:bg-red-50 transition focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tolak Data (Invalid)
                </button>
            </div>
        </form>
    </div>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-800 px-6 py-4">
        <h2 class="text-lg font-bold text-white">Status Validasi</h2>
    </div>
    <div class="p-6">
        <div class="text-center p-5 rounded-xl border-2
            {{ $dataStunting->status_validasi === 'Validated' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
            
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-3
                {{ $dataStunting->status_validasi === 'Validated' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($dataStunting->status_validasi === 'Validated')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    @endif
                </svg>
            </div>

            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status Akhir</p>
            <p class="text-xl font-black mt-1
                {{ $dataStunting->status_validasi === 'Validated' ? 'text-green-700' : 'text-red-700' }}">
                {{ $dataStunting->status_validasi === 'Validated' ? 'DATA VALID' : 'DITOLAK' }}
            </p>
            
            <div class="mt-4 pt-4 border-t border-gray-200/60 text-left">
                <div class="flex justify-between text-xs mb-2">
                    <span class="text-gray-500">Validator:</span>
                    <span class="font-medium text-gray-900">{{ $dataStunting->validator->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($dataStunting->tanggal_validasi)->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                    </span>
                </div>
            </div>
        </div>
        
        @if($dataStunting->catatan_validasi)
        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs font-bold text-gray-500 uppercase mb-1">Catatan Validator:</p>
            <p class="text-sm text-gray-800 italic">"{{ $dataStunting->catatan_validasi }}"</p>
        </div>
        @endif
    </div>
</div>
@endif