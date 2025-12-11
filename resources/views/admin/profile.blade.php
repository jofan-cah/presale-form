@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Profil Admin</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Update Profil</h2>

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Photo Section -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}"
                                 alt="Foto Profil"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="photo" id="photo" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, JPEG. Max: 2MB</p>
                        </div>
                    </div>
                    @if($user->photo)
                        <form method="POST" action="{{ route('admin.profile.delete-photo') }}" class="mt-2" onsubmit="return confirm('Yakin ingin menghapus foto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                Hapus Foto
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('name', $user->name) }}" required>
                </div>

                <!-- NIP -->
                <div class="mb-4">
                    <label for="nip" class="block text-gray-700 font-medium mb-2">NIP</label>
                    <input type="text" name="nip" id="nip"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('nip', $user->nip) }}" required>
                </div>

                <!-- Password Section -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password (Opsional)</h3>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password Baru</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</p>
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </main>
</div>
@endsection
