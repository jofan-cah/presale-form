@extends('layouts.app')

@section('title', 'Berhasil')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <svg class="w-20 h-20 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Data Berhasil Dikirim!</h1>

            <!-- Event Name Display -->
            <div class="mb-6 p-4 bg-green-50 rounded-lg">
                <p class="text-sm text-green-600 font-medium mb-1">Event:</p>
                <p class="text-lg font-semibold text-green-900">{{ $eventName }}</p>
            </div>

            <p class="text-gray-600 mb-8">Terima kasih telah mengisi form presale. Data Anda telah berhasil tersimpan.</p>
            <a href="{{ route('form.index') }}"
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Kembali ke Form
            </a>
        </div>
    </div>
</div>
@endsection
