@extends('layouts.app')

@section('title', 'Detail Validasi Data')
@section('breadcrumb', 'Puskesmas / Validasi Data / Detail')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    {{-- 1. Header --}}
    @include('puskesmas.validasi.partials.detail.header')

    {{-- 2. Status Banner (Only if Pending) --}}
    @include('puskesmas.validasi.partials.detail.status-banner')

    {{-- Main Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left Column (Data Details) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- 3. Data Anak & Orang Tua --}}
            @include('puskesmas.validasi.partials.detail.data-anak')

            {{-- 4. Data Pengukuran Antropometri --}}
            @include('puskesmas.validasi.partials.detail.data-pengukuran')

            {{-- 5. Hasil Analisis Z-Score --}}
            @include('puskesmas.validasi.partials.detail.hasil-analisis')

            {{-- 6. Chart Riwayat --}}
            @include('puskesmas.validasi.partials.detail.chart-riwayat')
        </div>

        {{-- Right Column (Actions & References) --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- 7. Action Card (Form Validasi) --}}
            @include('puskesmas.validasi.partials.detail.action-card')

            {{-- 8. Reference Card --}}
            @include('puskesmas.validasi.partials.detail.reference-card')
        </div>
    </div>
</div>

{{-- Scripts --}}
{{-- Jangan lupa include script chart dan validasi --}}
@include('puskesmas.validasi.scripts.validation')
@include('puskesmas.validasi.scripts.chart-riwayat')

<script>
// Fungsi Validasi Lokal (Jika ingin override script external)
function validateData(status) {
    const form = document.getElementById('validationForm');
    const formData = new FormData(form);
    const catatan = formData.get('catatan_validasi');
    const statusText = status === 'Validated' ? 'memvalidasi' : 'menolak';
    const color = status === 'Validated' ? '#16a34a' : '#dc2626';

    Swal.fire({
        title: `Konfirmasi ${status === 'Validated' ? 'Validasi' : 'Penolakan'}`,
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">Anda akan <strong>${statusText}</strong> data ini.</p>
                ${catatan ? `<div class="bg-gray-50 p-3 rounded border text-sm text-gray-700">"${catatan}"</div>` : ''}
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch('{{ route("puskesmas.validasi.proses", $dataStunting->id_stunting) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status_validasi: status,
                    catatan_validasi: catatan
                })
            })
            .then(response => {
                if (!response.ok) throw new Error(response.statusText);
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: result.value.message,
                confirmButtonColor: '#000878',
            }).then(() => {
                window.location.href = '{{ route("puskesmas.validasi.index") }}';
            });
        }
    });
}
</script>
@endsection