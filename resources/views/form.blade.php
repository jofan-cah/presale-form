@extends('layouts.app')

@section('title', 'Form Presale')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $eventName }}</h1>
            <p class="text-gray-600 mb-8">{{ $eventDescription }}</p>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('form.submit') }}" id="presaleForm">
                @csrf
                @if($token)
                    <input type="hidden" name="token" value="{{ $token }}">
                @endif

                <div class="mb-6">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('nama') }}" required>
                </div>

                <div class="mb-6">
                    <label for="nomor_hp" class="block text-gray-700 font-medium mb-2">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="nomor_hp" id="nomor_hp"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('nomor_hp') }}" required>
                </div>

                <div class="mb-6">
                    <label for="alamat" class="block text-gray-700 font-medium mb-2">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              required>{{ old('alamat') }}</textarea>
                </div>

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

                <button type="submit"
                        class="w-full bg-green-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-green-700 transition text-lg">
                    Submit Form
                </button>
            </form>
        </div>
    </div>
</div>

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
@endsection
