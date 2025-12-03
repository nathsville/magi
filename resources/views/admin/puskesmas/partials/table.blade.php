<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-primary to-blue-900 text-white">
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                        Nama Puskesmas
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                        Alamat
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                        Kecamatan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                        Jumlah Posyandu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($puskesmas as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->nama_puskesmas }}
                                </div>
                                @if($item->no_telepon)
                                <div class="text-xs text-gray-500">
                                    📞 {{ $item->no_telepon }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($item->alamat, 40) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $item->kecamatan }}</div>
                        <div class="text-xs text-gray-500">{{ $item->kabupaten }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $item->posyandu_count }} Posyandu
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->status === 'Aktif')
                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.puskesmas.edit', $item->id_puskesmas) }}" 
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.puskesmas.destroy', $item->id_puskesmas) }}" 
                            method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                onclick="confirmDeletePuskesmas(this)"
                                data-nama="{{ $item->nama_puskesmas }}"
                                data-posyandu="{{ $item->posyandu_count }}"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" 
                                title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($puskesmas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $puskesmas->links() }}
    </div>
    @endif
</div>