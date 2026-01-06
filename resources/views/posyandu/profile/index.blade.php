@extends('layouts.app')

@section('title', 'Profil Saya')
@section('breadcrumb', 'Posyandu / Profil Saya')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- 1. Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola informasi akun dan keamanan</p>
            </div>
        </div>
        
        <a href="{{ route('posyandu.dashboard') }}" 
            class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium text-sm">Kembali</span>
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        @include('posyandu.partials.alert-success', ['message' => session('success')])
    @endif
    @if($errors->any())
        @include('posyandu.partials.alert-error', ['message' => 'Terdapat kesalahan pada form. Silakan periksa kembali inputan Anda.'])
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Total Input --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Input</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['total_input'] }}</p>
            </div>
        </div>
        {{-- Bulan Ini --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Bulan Ini</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['bulan_ini'] }}</p>
            </div>
        </div>
        {{-- Terakhir Input --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Terakhir Input</p>
                <p class="text-sm font-bold text-gray-900">
                    @if($stats['terakhir_input'])
                        {{ \Carbon\Carbon::parse($stats['terakhir_input']->created_at)->diffForHumans() }}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- 3. Left Column: Read-Only Information --}}
        <div class="space-y-6">
            {{-- Data Akun --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        Data Akun
                    </h2>
                </div>
                <div class="p-6">
                    {{-- Avatar & Basic Info --}}
                    <div class="flex flex-col items-center text-center pb-6 border-b border-gray-100">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold text-white mb-3 shadow-md bg-gradient-to-br from-blue-500 to-blue-600">
                            {{ substr($user->nama, 0, 1) }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $user->nama }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $user->role }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status }}
                        </span>
                    </div>

                    {{-- Detail Info Table --}}
                    <div class="pt-4 space-y-3">
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <span class="text-gray-500">Username</span>
                            <span class="col-span-2 font-mono font-medium text-gray-900">{{ $user->username }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <span class="text-gray-500">Bergabung</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lokasi Posyandu --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Lokasi Posyandu
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    {{-- Menggunakan Grid agar alignment lebih rapi (Label Kiri, Isi Kanan) --}}
                    <div class="grid grid-cols-3 gap-2 text-sm border-b border-gray-50 pb-3">
                        <span class="text-gray-500">Nama</span>
                        <span class="col-span-2 font-semibold text-gray-900">{{ $posyandu->nama_posyandu }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm border-b border-gray-50 pb-3">
                        <span class="text-gray-500">Alamat</span>
                        <span class="col-span-2 font-medium text-gray-900">{{ $posyandu->alamat }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <span class="text-gray-500">Wilayah</span>
                        <span class="col-span-2 font-medium text-gray-900">{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Right Column: Editable Forms --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Edit Profil Form --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profil
                    </h2>
                </div>

                <form method="POST" action="{{ route('posyandu.profile.update') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('nama') border-red-500 @enderror">
                                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- No Telepon --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('no_telepon') border-red-500 @enderror">
                                @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-6 py-2 bg-[#000878] text-white text-sm font-bold rounded-lg hover:bg-blue-900 shadow-md hover:shadow-lg transition flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Ubah Password Form --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Ubah Password
                    </h2>
                </div>

                <form method="POST" action="{{ route('posyandu.profile.update') }}" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- Hidden fields to preserve other data --}}
                    <input type="hidden" name="nama" value="{{ $user->nama }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="no_telepon" value="{{ $user->no_telepon }}">

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="password" minlength="8"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors @error('password') border-red-500 @enderror">
                                <p class="text-[11px] text-gray-500 mt-1">Min. 8 karakter. Kosongkan jika tidak ubah.</p>
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" minlength="8"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-6 py-2 bg-gray-800 text-white text-sm font-bold rounded-lg hover:bg-gray-900 shadow-md hover:shadow-lg transition flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 19l-1 1-1 1-2-2-1 1-1 1-2-2 1-1 1-1 2-2 1-1 1-1 5.743-7.743A6 6 0 0115 7z"></path></svg>
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection