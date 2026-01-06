<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MaGi') - Sistem Monitoring Stunting</title>
    
    {{-- Laravel Vite (Tailwind CSS & JS Bundle) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom Scrollbar Styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        /* SweetAlert2 Custom Styling agar cocok dengan tema MaGi */
        .swal2-styled.swal2-confirm {
            background-color: #000878 !important;
        }
        .swal2-styled.swal2-confirm:focus {
            box-shadow: 0 0 0 3px rgba(0, 8, 120, 0.5) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    {{-- Mobile Overlay (Background gelap saat sidebar terbuka di mobile) --}}
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-black/50 hidden transition-opacity opacity-0 md:hidden backdrop-blur-sm"></div>

    <div class="flex min-h-screen">
        
        {{-- SIDEBAR SECTION --}}
        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 flex flex-col h-full w-64 bg-gradient-to-b from-[#000878] to-slate-900 text-white shadow-2xl transition-transform duration-300 transform -translate-x-full md:translate-x-0">
            
            {{-- Sidebar Header --}}
            <div class="p-6 border-b border-white/10 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 p-2 rounded-lg shadow-lg shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-wider font-sans">MaGi</h1>
                        <p class="text-[10px] text-blue-200 uppercase tracking-widest font-semibold">Monitoring Stunting</p>
                    </div>
                </div>

                {{-- Close Button (Mobile Only) --}}
                <button onclick="toggleSidebar()" class="md:hidden text-white/70 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Sidebar Menu --}}
            {{-- PERUBAHAN: Bagian Profil User lama di bawah ini SUDAH DIHAPUS. --}}
            {{-- Profil user sekarang dimuat otomatis melalui @yield('sidebar') dari file sidebar-menu.blade.php --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar flex flex-col">
                @yield('sidebar')
            </nav>
            
        </aside>

        {{-- MAIN CONTENT SECTION --}}
        <main class="flex-1 ml-0 md:ml-64 transition-all duration-300 min-w-0">
            
            {{-- Header Navbar --}}
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="px-4 sm:px-6 py-4 flex items-center justify-between">
                    
                    <div class="flex items-center gap-3">
                        {{-- Hamburger Button (Mobile) --}}
                        <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        {{-- Page Title / Header --}}
                        <div class="flex flex-col">
                             <h2 class="text-lg sm:text-xl font-semibold text-gray-800 truncate">@yield('header')</h2>
                             <div class="text-xs text-gray-500 hidden sm:block">@yield('breadcrumb')</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        @php
                            $userRole = auth()->user()->role;
                            $notifRoute = '#';

                            if ($userRole === 'Petugas Posyandu') {
                                $notifRoute = route('posyandu.notifikasi.index');
                            } 
                            elseif ($userRole === 'Petugas Puskesmas') {
                                $notifRoute = Route::has('puskesmas.notifikasi.index') ? route('puskesmas.notifikasi.index') : '#';
                            }
                            elseif ($userRole === 'Orang Tua') {
                                $notifRoute = route('orangtua.notifikasi.index');
                            }
                            elseif ($userRole === 'Petugas DPPKB') {
                                $notifRoute = Route::has('dppkb.notifikasi') ? route('dppkb.notifikasi') : '#';
                            }
                        @endphp

                        {{-- Notification Icon Link --}}
                        <a href="{{ $notifRoute }}" class="relative p-1 rounded-full hover:bg-gray-100 transition-colors inline-block">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            
                            {{-- Indikator Merah --}}
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </a>
                        
                        <div class="hidden sm:block text-sm text-gray-600 font-medium">
                            {{ now()->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="p-4 sm:p-6">
                {{-- Fallback Alerts (HTML version) --}}
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex" role="alert">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Berhasil</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex" role="alert">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Error</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                         <p class="font-bold">Perhatikan:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    @stack('scripts')

    <script>
        // --- 1. Sidebar Logic ---
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        // --- 2. SweetAlert2 Configuration ---
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        window.showSuccessToast = function(message) {
            Toast.fire({ icon: 'success', title: message });
        };

        window.showErrorToast = function(message) {
            Toast.fire({ icon: 'error', title: message });
        };

        window.showInfoToast = function(message) {
            Toast.fire({ icon: 'info', title: message });
        };

        // Fungsi Global untuk konfirmasi hapus
        window.confirmDelete = function(message = 'Data yang sudah dihapus tidak dapat dikembalikan!') {
            return Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000878',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            });
        };

        // --- 3. Auto Trigger Toast from Laravel Session ---
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                window.showSuccessToast("{{ session('success') }}");
            @endif

            @if(session('error'))
                window.showErrorToast("{{ session('error') }}");
            @endif
        });

        // Helpers untuk alert manual
        window.showSuccess = function(title, text = '') {
            Swal.fire({ icon: 'success', title: title, text: text, confirmButtonColor: '#000878', confirmButtonText: 'OK', timer: 3000, timerProgressBar: true });
        };
        window.showError = function(title, text = '') {
            Swal.fire({ icon: 'error', title: title, text: text, confirmButtonColor: '#dc2626', confirmButtonText: 'OK' });
        };
        window.showInfo = function(title, text = '') {
            Swal.fire({ icon: 'info', title: title, text: text, confirmButtonColor: '#000878', confirmButtonText: 'OK' });
        };
        window.showWarning = function(title, text = '') {
            Swal.fire({ icon: 'warning', title: title, text: text, confirmButtonColor: '#f59e0b', confirmButtonText: 'OK' });
        };
        window.showLoading = function(title = 'Memproses...', text = 'Mohon tunggu') {
            Swal.fire({ title: title, text: text, allowOutsideClick: false, allowEscapeKey: false, didOpen: () => { Swal.showLoading(); } });
        };
    </script>
</body>
</html>