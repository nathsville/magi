@extends('layouts.app')

@section('title', $artikel['judul'])

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="mb-4">
        <a href="{{ route('orangtua.edukasi.index') }}" class="inline-flex items-center text-gray-600 hover:text-[#000878] font-medium text-sm transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Edukasi
        </a>
    </div>

    <article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Header Image --}}
        @include('orangtua.edukasi.partials.show.header', ['artikel' => $artikel])

        <div class="p-8">
            {{-- Meta Info --}}
            @include('orangtua.edukasi.partials.show.meta', ['artikel' => $artikel])

            {{-- Main Content --}}
            @include('orangtua.edukasi.partials.show.content', ['artikel' => $artikel])

            {{-- Dynamic Sections --}}
            @if(isset($artikel['konten']['tips']))
                @include('orangtua.edukasi.partials.show.tips', ['tips' => $artikel['konten']['tips']])
            @endif

            @if(isset($artikel['konten']['fakta']))
                @include('orangtua.edukasi.partials.show.facts', ['fakta' => $artikel['konten']['fakta']])
            @endif

            @if(isset($artikel['konten']['contoh_menu']))
                @include('orangtua.edukasi.partials.show.menu', ['menu' => $artikel['konten']['contoh_menu']])
            @endif

            @if(isset($artikel['konten']['jadwal']))
                @include('orangtua.edukasi.partials.show.schedule', ['jadwal' => $artikel['konten']['jadwal']])
            @endif
        </div>

        {{-- Share Section --}}
        @include('orangtua.edukasi.partials.show.share', ['artikel' => $artikel])
    </article>

    {{-- Related Articles --}}
    @if(!empty($relatedArticles))
        @include('orangtua.edukasi.partials.show.related', ['relatedArticles' => $relatedArticles])
    @endif
</div>
@endsection

@push('scripts')
@include('orangtua.edukasi.scripts.detail')
@endpush