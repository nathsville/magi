<div class="prose max-w-none text-gray-700 leading-relaxed">
    <p class="font-medium text-lg text-gray-800 mb-6 italic border-l-4 border-[#000878] pl-4 bg-gray-50 py-2 rounded-r">
        {{ $artikel['ringkasan'] }}
    </p>
    @foreach($artikel['konten']['paragraf'] as $paragraf)
        <p class="mb-4 text-justify">{{ $paragraf }}</p>
    @endforeach
</div>