<div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
    {{-- Table Header --}}
    <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
        <h2 class="text-lg font-semibold text-white">{{ $tipe }}</h2>
        <p class="text-blue-100 text-sm">{{ $items->count() }} data</p>
    </div>
    
    {{-- Table Content --}}
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($items as $data)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $data->kode }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $data->nilai }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ Str::limit($data->deskripsi, 80) }}
                </td>
                <td class="px-6 py-4">
                    @if($data->status == 'Aktif')
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.datamaster.edit', $data->id_master) }}" 
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.datamaster.destroy', $data->id_master) }}" 
                            method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                onclick="confirmDeleteData(this)" 
                                data-kode="{{ $data->kode }}"
                                data-nilai="{{ $data->nilai }}"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" 
                                title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>