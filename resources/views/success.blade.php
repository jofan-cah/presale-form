@extends('layouts.app')

@section('title', 'Berhasil')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Purple Header -->
            <div class="bg-purple-600 px-8 py-4">
                <h1 class="text-xl font-normal text-white">Respons Anda telah direkam</h1>
            </div>

            <!-- Content -->
            <div class="px-8 py-10 text-center">
                <div class="mb-6">
                    <svg class="w-16 h-16 mx-auto text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Event Name Display -->
                <div class="mb-6 p-4 bg-purple-50 rounded-lg border-l-4 border-purple-600">
                    <p class="text-xs text-purple-600 font-medium mb-1">Event:</p>
                    <p class="text-base font-medium text-purple-900">{{ $eventName }}</p>
                </div>

                <p class="text-gray-600 text-sm mb-8">Terima kasih telah mengisi formulir. Respons Anda telah berhasil tersimpan.</p>

                <a href="{{ route('form.index') }}"
                   class="inline-block bg-purple-600 text-white text-sm font-medium px-6 py-2 rounded hover:bg-purple-700 transition shadow-md">
                    Kirim respons lain
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-white text-xs opacity-75">Terima kasih atas partisipasi Anda</p>
        </div>
    </div>
</div>
@endsection
