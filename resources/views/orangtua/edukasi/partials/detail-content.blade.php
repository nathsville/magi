<div class="prose prose-lg max-w-none">
    @foreach($artikel['konten']['paragraf'] as $paragraf)
        <p class="text-gray-700 leading-relaxed mb-6 text-justify">
            {{ $paragraf }}
        </p>
    @endforeach
</div>