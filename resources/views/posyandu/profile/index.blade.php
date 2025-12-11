@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50">
    @include('posyandu.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-5xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('posyandu.dashboard') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>

        {{-- Page Header --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-user-circle text-teal-600 mr-3"></i>Profil Saya
            </h1>
            <p class="text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            @include('posyandu.partials.alert-success', ['message' => session('success')])
        @endif

        @if($errors->any())
            @include('posyandu.partials.alert-error', ['message' => 'Terdapat kesalahan pada form'])
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Profile Info --}}
            <div class="space-y-6">
                {{-- Avatar Card --}}
                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl shadow-lg p-6 text-white text-center">
                    <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-5xl mx-auto mb-4">
                        👤
                    </div>
                    <h3 class="text-xl font-bold mb-1">{{ $user->nama }}</h3>
                    <p class="text-sm text-teal-100 mb-4">{{ $user->role }}</p>
                    <span class="px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                        {{ $user->status }}
                    </span>
                </div>

                {{-- Stats Card --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-chart-line text-teal-600 mr-2"></i>Statistik Aktivitas
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Total Input</span>
                            <span class="text-sm font-bold text-gray-800">{{ $stats['total_input'] }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Bulan Ini</span>
                            <span class="text-sm font-bold text-teal-600">{{ $stats['bulan_ini'] }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600">Terakhir Input</span>
                            <span class="text-sm font-bold text-gray-800">
                                @if($stats['terakhir_input'])
                                    {{ \Carbon\Carbon::parse($stats['terakhir_input']->created_at)->diffForHumans() }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Posyandu Info --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-hospital text-teal-600 mr-2"></i>Posyandu
                    </h3>
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-800">{{ $posyandu->nama_posyandu }}</p>
                        <p class="text-sm text-gray-600">{{ $posyandu->alamat }}</p>
                        <p class="text-sm text-gray-600">{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Edit Forms --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Edit Profile Form --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-edit text-teal-600 mr-2"></i>Edit Profil
                    </h3>

                    <form method="POST" action="{{ route('posyandu.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama" 
                                       value="{{ old('nama', $user->nama) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                                @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No Telepon --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    No. Telepon
                                </label>
                                <input type="text" 
                                       name="no_telepon" 
                                       value="{{ old('no_telepon', $user->no_telepon) }}"
                                       maxlength="15"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('no_telepon') border-red-500 @enderror">
                                @error('no_telepon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Username (read-only) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Username
                                </label>
                                <input type="text" 
                                       value="{{ $user->username }}"
                                       readonly
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                                <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah</p>
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-4">
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-bold rounded-lg hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Change Password Form --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-key text-teal-600 mr-2"></i>Ubah Password
                    </h3>

                    <form method="POST" action="{{ route('posyandu.profile.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Hidden fields to preserve other data --}}
                        <input type="hidden" name="nama" value="{{ $user->nama }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="no_telepon" value="{{ $user->no_telepon }}">

                        <div class="space-y-4">
                            {{-- New Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" 
                                       name="password" 
                                       minlength="8"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</p>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       minlength="8"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-4">
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold rounded-lg hover:from-purple-700 hover:to-purple-800 transition shadow-lg">
                                    <i class="fas fa-lock mr-2"></i>Ubah Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection