@extends('layouts.app')

@section('title', 'Form Presale')

@section('content')
<div class="min-h-screen py-8 px-4 sm:py-12" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-2xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-4 transform hover:scale-[1.01] transition-transform duration-300">
            <div class="border-l-8 border-purple-600 px-6 py-6 sm:px-8 sm:py-8">
                <div class="flex items-start space-x-4">
                    <div class="hidden sm:block">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">{{ $eventName }}</h1>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">{{ $eventDescription }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-xl shadow-lg overflow-hidden animate-shake">
                <div class="px-6 py-4 sm:px-8 sm:py-5">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-red-800 mb-2">Mohon perbaiki kesalahan berikut:</p>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('form.submit') }}" id="presaleForm" class="space-y-4">
            @csrf

            <!-- Honeypot field untuk bot protection (hidden) -->
            <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

            <!-- Question Cards -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:shadow-xl transition-all duration-300">
                <div class="px-6 py-6 sm:px-8 sm:py-7">
                    <label for="nama" class="flex items-center text-gray-800 font-semibold mb-3 text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Nama Lengkap <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama" id="nama"
                               class="w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-0 transition-all duration-300 text-gray-800 placeholder-gray-400"
                               placeholder="Masukkan nama lengkap Anda"
                               value="{{ old('nama') }}" required>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-600 to-pink-500 transition-all duration-300 peer-focus:w-full"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:shadow-xl transition-all duration-300">
                <div class="px-6 py-6 sm:px-8 sm:py-7">
                    <label for="nomor_hp" class="flex items-center text-gray-800 font-semibold mb-3 text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Nomor HP <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input type="tel" name="nomor_hp" id="nomor_hp"
                               class="w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-0 transition-all duration-300 text-gray-800 placeholder-gray-400"
                               placeholder="Contoh: 081234567890"
                               value="{{ old('nomor_hp') }}" required>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Format: 08xxxxxxxxxx</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:shadow-xl transition-all duration-300">
                <div class="px-6 py-6 sm:px-8 sm:py-7">
                    <label for="alamat" class="flex items-center text-gray-800 font-semibold mb-3 text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="alamat" id="alamat" rows="4"
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 transition-all duration-300 resize-none text-gray-800 placeholder-gray-400"
                                  placeholder="Masukkan alamat lengkap Anda (Jalan, RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota)"
                                  required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-6 sm:px-8 sm:py-7">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                        <button type="submit"
                                class="w-full sm:w-auto bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold py-3 px-10 rounded-xl hover:from-purple-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                            <span>Kirim</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        <div class="flex items-center justify-center sm:justify-start text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>Wajib diisi</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Footer Text -->
        <div class="text-center mt-8 animate-fade-in">
            <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p class="text-white text-xs font-medium">Form ini dibuat untuk keperluan pendaftaran event</p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }

    /* Smooth focus effect */
    input:focus, textarea:focus {
        transform: translateY(-2px);
    }

    /* Mobile optimizations */
    @media (max-width: 640px) {
        .bg-white.rounded-2xl {
            border-radius: 1rem;
        }
    }
</style>

@endsection
