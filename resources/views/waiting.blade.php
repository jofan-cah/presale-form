@extends('layouts.app')

@section('title', 'Sedang Menunggu Event')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <!-- Icon -->
            <div class="mb-6">
                <svg class="w-24 h-24 mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Sedang Menunggu Event</h1>

            <!-- Event Name -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-600 font-medium mb-1">Event:</p>
                <p class="text-lg font-semibold text-blue-900">{{ $eventName }}</p>
            </div>

            <!-- Description -->
            <p class="text-gray-600 mb-8">
                Formulir pendaftaran saat ini sedang tidak aktif. Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.
            </p>

            <!-- Info Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-left">
                        <p class="text-sm text-yellow-800 font-medium">Informasi</p>
                        <p class="text-sm text-yellow-700">Form akan aktif kembali saat event dibuka oleh admin.</p>
                    </div>
                </div>
            </div>

            <!-- Refresh Button -->
            <button onclick="window.location.reload()"
                    class="w-full bg-blue-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh Halaman
            </button>
        </div>
    </div>
</div>
@endsection
