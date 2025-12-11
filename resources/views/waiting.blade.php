@extends('layouts.app')

@section('title', 'Sedang Menunggu Event')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Purple Header -->
            <div class="bg-purple-600 px-8 py-4">
                <h1 class="text-xl font-normal text-white">Formulir Belum Tersedia</h1>
            </div>

            <!-- Content -->
            <div class="px-8 py-10 text-center">
                <!-- Icon -->
                <div class="mb-6">
                    <svg class="w-16 h-16 mx-auto text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Event Name -->
                <div class="mb-6 p-4 bg-purple-50 rounded-lg border-l-4 border-purple-600">
                    <p class="text-xs text-purple-600 font-medium mb-1">Event:</p>
                    <p class="text-base font-medium text-purple-900">{{ $eventName }}</p>
                </div>

                <!-- Description -->
                <p class="text-gray-600 text-sm mb-6">
                    Formulir pendaftaran saat ini sedang tidak aktif. Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.
                </p>

                <!-- Info Box -->
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 text-left">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-amber-800 font-medium">Informasi</p>
                            <p class="text-xs text-amber-700 mt-1">Form akan aktif kembali saat event dibuka oleh admin.</p>
                        </div>
                    </div>
                </div>

                <!-- Refresh Button -->
                <button onclick="window.location.reload()"
                        class="bg-purple-600 text-white text-sm font-medium py-2 px-6 rounded hover:bg-purple-700 transition shadow-md inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Halaman
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-white text-xs opacity-75">Mohon tunggu pengumuman lebih lanjut</p>
        </div>
    </div>
</div>
@endsection
