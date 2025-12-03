<div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
    <div class="text-xs text-gray-500">
        Log ID: <span class="font-mono">#{{ $log->id_audit }}</span>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.audit-log.filter') }}" 
            class="text-sm font-medium text-gray-700 hover:text-gray-900">
            Lihat Semua Log
        </a>
        <span class="text-gray-300">•</span>
        <a href="{{ route('admin.audit-log') }}" 
            class="text-sm font-medium text-primary hover:text-blue-900">
            Kembali ke Dashboard
        </a>
    </div>
</div>