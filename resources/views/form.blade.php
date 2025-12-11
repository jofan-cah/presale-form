@extends('layouts.app')

@section('title', 'Form Presale')

{{-- Leaflet CSS - Uncomment jika perlu map lagi
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
--}}

@section('content')
<div class="min-h-screen py-12 px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-2xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-t-lg shadow-md overflow-hidden mb-3">
            <div class="border-l-8 border-purple-600 px-8 py-6">
                <h1 class="text-3xl font-normal text-gray-800 mb-2">{{ $eventName }}</h1>
                <p class="text-sm text-gray-600">{{ $eventDescription }}</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-3 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded shadow-sm">
                <p class="font-medium mb-2">Mohon perbaiki kesalahan berikut:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('form.submit') }}" id="presaleForm">
            @csrf

            <!-- Honeypot field untuk bot protection (hidden) -->
            <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

            <!-- Question Cards -->
            <div class="bg-white rounded-lg shadow-md mb-3 px-8 py-6">
                <label for="nama" class="block text-gray-800 font-normal mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" id="nama"
                       class="w-full px-0 py-2 border-0 border-b-2 border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-0 transition-colors"
                       placeholder="Jawaban Anda"
                       value="{{ old('nama') }}" required>
            </div>

            <div class="bg-white rounded-lg shadow-md mb-3 px-8 py-6">
                <label for="nomor_hp" class="block text-gray-800 font-normal mb-2">
                    Nomor HP <span class="text-red-500">*</span>
                </label>
                <input type="tel" name="nomor_hp" id="nomor_hp"
                       class="w-full px-0 py-2 border-0 border-b-2 border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-0 transition-colors"
                       placeholder="Jawaban Anda"
                       value="{{ old('nomor_hp') }}" required>
            </div>

            <div class="bg-white rounded-lg shadow-md mb-3 px-8 py-6">
                <label for="alamat" class="block text-gray-800 font-normal mb-2">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" id="alamat" rows="3"
                          class="w-full px-0 py-2 border-0 border-b-2 border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-0 transition-colors resize-none"
                          placeholder="Jawaban Anda"
                          required>{{ old('alamat') }}</textarea>
            </div>

                {{-- Map section - Hidden (tidak digunakan untuk saat ini) --}}
                {{-- Uncomment section ini jika perlu menggunakan koordinat lagi
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">
                        Lokasi (Latitude/Longitude)
                    </label>
                    <div class="mb-3">
                        <button type="button" onclick="getMyLocation()" id="locationBtn"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Gunakan Lokasi Saya
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <input type="text" name="latitude" id="latitude" placeholder="Latitude"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('latitude') }}" readonly>
                        </div>
                        <div>
                            <input type="text" name="longitude" id="longitude" placeholder="Longitude"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('longitude') }}" readonly>
                        </div>
                    </div>
                    <div id="map" class="h-64 rounded-lg border border-gray-300"></div>
                </div>
                --}}

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow-md px-8 py-6">
                <div class="flex justify-between items-center">
                    <button type="submit"
                            class="bg-purple-600 text-white font-medium py-2 px-8 rounded hover:bg-purple-700 transition shadow-md">
                        Kirim
                    </button>
                    <p class="text-xs text-gray-500">* Wajib diisi</p>
                </div>
            </div>
        </form>

        <!-- Footer Text -->
        <div class="text-center mt-6">
            <p class="text-white text-xs opacity-75">Form ini dibuat untuk keperluan pendaftaran event</p>
        </div>
    </div>
</div>

{{-- Leaflet Map Scripts - Uncomment jika perlu map lagi
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let marker;
const defaultLat = -7.7056;
const defaultLng = 110.6061;

// Initialize map
map = L.map('map').setView([defaultLat, defaultLng], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Add click event to map
map.on('click', function(e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;
    setLocation(lat, lng);
});

function setLocation(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);

    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }

    map.setView([lat, lng], 15);
}

function getMyLocation() {
    const btn = document.getElementById('locationBtn');
    btn.disabled = true;
    btn.textContent = 'Mendapatkan lokasi...';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                setLocation(lat, lng);
                btn.disabled = false;
                btn.textContent = 'Gunakan Lokasi Saya';
            },
            function(error) {
                alert('Tidak bisa mendapatkan lokasi: ' + error.message);
                btn.disabled = false;
                btn.textContent = 'Gunakan Lokasi Saya';
            }
        );
    } else {
        alert('Geolocation tidak didukung oleh browser Anda');
        btn.disabled = false;
        btn.textContent = 'Gunakan Lokasi Saya';
    }
}
</script>
@endpush
--}}
@endsection
