@if($log->old_values || $log->new_values)
<div class="mt-6">
    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
        </svg>
        Data Changes
    </h3>

    @if($log->action === 'UPDATE' && $log->old_values && $log->new_values)
    {{-- Show Comparison for UPDATE --}}
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Sebelum</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12"></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Sesudah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $oldValues = is_array($log->old_values) ? $log->old_values : json_decode($log->old_values, true);
                        $newValues = is_array($log->new_values) ? $log->new_values : json_decode($log->new_values, true);
                    @endphp

                    @foreach($newValues as $key => $newValue)
                        @if(isset($oldValues[$key]) && $oldValues[$key] != $newValue && !in_array($key, ['updated_at', 'created_at', 'password']))
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                                    <span class="text-sm text-red-700 break-all">
                                        {{ is_array($oldValues[$key]) ? json_encode($oldValues[$key]) : ($oldValues[$key] ?: '-') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </td>
                            <td class="px-6 py-4">
                                <div class="bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                    <span class="text-sm text-green-700 break-all">
                                        {{ is_array($newValue) ? json_encode($newValue) : ($newValue ?: '-') }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @elseif($log->action === 'CREATE' && $log->new_values)
    {{-- Show New Data for CREATE --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h4 class="text-sm font-semibold text-gray-700 mb-4">Data Baru:</h4>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <pre class="text-sm text-green-800 whitespace-pre-wrap break-all">{{ json_encode(is_array($log->new_values) ? $log->new_values : json_decode($log->new_values, true), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    @elseif($log->action === 'DELETE' && $log->old_values)
    {{-- Show Old Data for DELETE --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h4 class="text-sm font-semibold text-gray-700 mb-4">Data yang Dihapus:</h4>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <pre class="text-sm text-red-800 whitespace-pre-wrap break-all">{{ json_encode(is_array($log->old_values) ? $log->old_values : json_decode($log->old_values, true), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    @else
    {{-- Fallback: Show Raw JSON --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        @if($log->old_values)
        <div class="mb-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Old Values:</h4>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <pre class="text-xs text-gray-700 whitespace-pre-wrap break-all">{{ json_encode(is_array($log->old_values) ? $log->old_values : json_decode($log->old_values, true), JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif

        @if($log->new_values)
        <div>
            <h4 class="text-sm font-semibold text-gray-700 mb-2">New Values:</h4>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <pre class="text-xs text-gray-700 whitespace-pre-wrap break-all">{{ json_encode(is_array($log->new_values) ? $log->new_values : json_decode($log->new_values, true), JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
@endif