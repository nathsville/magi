<div class="bg-white rounded-2xl shadow-lg p-12 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-user-slash text-gray-400 text-4xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $title ?? 'Tidak Ada Data' }}</h3>
    <p class="text-gray-600 mb-6 max-w-md mx-auto">
        {{ $message ?? 'Belum ada data yang tersedia saat ini.' }}
    </p>
    @if(isset($action))
    <a href="{{ $action['url'] }}" class="inline-block px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-bold rounded-lg hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
        <i class="fas {{ $action['icon'] }} mr-2"></i>{{ $action['text'] }}
    </a>
    @endif
</div>