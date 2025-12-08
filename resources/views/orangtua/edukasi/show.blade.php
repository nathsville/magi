@extends('layouts.app')

@section('title', $artikel['judul'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-5xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('orangtua.edukasi.index') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Edukasi
            </a>
        </div>

        {{-- Article Card --}}
        <article class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            {{-- Header Image --}}
            @include('orangtua.edukasi.partials.detail-header', ['artikel' => $artikel])

            {{-- Content --}}
            <div class="p-8 md:p-12">
                {{-- Meta Info --}}
                @include('orangtua.edukasi.partials.detail-meta', ['artikel' => $artikel])

                {{-- Main Content --}}
                @include('orangtua.edukasi.partials.detail-content', ['artikel' => $artikel])

                {{-- Tips Section --}}
                @if(isset($artikel['konten']['tips']))
                    @include('orangtua.edukasi.partials.detail-tips', ['tips' => $artikel['konten']['tips']])
                @endif

                {{-- Facts Section --}}
                @if(isset($artikel['konten']['fakta']))
                    @include('orangtua.edukasi.partials.detail-facts', ['fakta' => $artikel['konten']['fakta']])
                @endif

                {{-- Additional Sections (Menu, Jadwal, etc.) --}}
                @if(isset($artikel['konten']['contoh_menu']))
                    @include('orangtua.edukasi.partials.detail-menu', ['menu' => $artikel['konten']['contoh_menu']])
                @endif

                @if(isset($artikel['konten']['jadwal']))
                    @include('orangtua.edukasi.partials.detail-schedule', ['jadwal' => $artikel['konten']['jadwal']])
                @endif
            </div>

            {{-- Share Section --}}
            @include('orangtua.edukasi.partials.detail-share', ['artikel' => $artikel])
        </article>

        {{-- Related Articles --}}
        @if(!empty($relatedArticles))
            @include('orangtua.edukasi.partials.related-articles', ['relatedArticles' => $relatedArticles])
        @endif
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.edukasi.scripts.detail')
@endpush