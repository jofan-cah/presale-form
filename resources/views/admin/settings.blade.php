@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Perusahaan</h1>
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
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Pengaturan Sistem</h2>

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Event Settings Section -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Event & Form</h3>

                    <!-- Event Name -->
                    <div class="mb-4">
                        <label for="event_name" class="block text-gray-700 font-medium mb-2">Nama Event</label>
                        <input type="text" name="event_name" id="event_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('event_name', $eventName) }}" required
                               placeholder="Contoh: Event Presale Perumahan Green Valley">
                        <p class="text-sm text-gray-500 mt-1">Nama event akan ditampilkan di halaman form</p>
                    </div>

                    <!-- Event Description -->
                    <div class="mb-4">
                        <label for="event_description" class="block text-gray-700 font-medium mb-2">Deskripsi Event</label>
                        <textarea name="event_description" id="event_description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required
                                  placeholder="Contoh: Silakan isi formulir di bawah ini untuk mendaftar event presale perumahan">{{ old('event_description', $eventDescription) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Deskripsi akan ditampilkan di bawah nama event</p>
                    </div>

                    <!-- Form Status -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Status Form</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="form_status" value="active"
                                       class="w-4 h-4 text-green-600 focus:ring-green-500"
                                       {{ old('form_status', $formStatus) === 'active' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">
                                    <span class="font-medium text-green-600">Aktif</span> - Form dapat diakses
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="form_status" value="inactive"
                                       class="w-4 h-4 text-red-600 focus:ring-red-500"
                                       {{ old('form_status', $formStatus) === 'inactive' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">
                                    <span class="font-medium text-red-600">Nonaktif</span> - Tampil pesan "Sedang menunggu event"
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Company Settings Section -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Perusahaan</h3>

                    <!-- Company Name -->
                    <div class="mb-6">
                        <label for="company_name" class="block text-gray-700 font-medium mb-2">Nama Perusahaan</label>
                        <input type="text" name="company_name" id="company_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('company_name', $companyName) }}" required>
                    </div>
                </div>

                <!-- Company Logo -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Logo Perusahaan (untuk QR Code)</label>
                    <p class="text-sm text-gray-600 mb-3">Logo akan ditampilkan di tengah QR Code. Gunakan logo berbentuk persegi untuk hasil terbaik.</p>

                    @if($companyLogo)
                        <div class="mb-4 flex items-center gap-4" id="currentLogoSection">
                            <div class="border border-gray-300 rounded-lg p-2 bg-white">
                                <img src="{{ asset('storage/' . $companyLogo) }}"
                                     alt="Logo Perusahaan"
                                     class="w-24 h-24 object-contain"
                                     id="currentLogoImg">
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Logo saat ini</p>
                                <button type="button" onclick="deleteLogo()"
                                        class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700 transition">
                                    Hapus Logo
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="mb-4 p-4 border-2 border-dashed border-gray-300 rounded-lg text-center" id="noLogoSection">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-gray-600">Belum ada logo</p>
                        </div>
                    @endif

                    <!-- Preview area untuk logo baru -->
                    <div class="mb-4 hidden" id="newLogoPreview">
                        <div class="flex items-center gap-4">
                            <div class="border border-gray-300 rounded-lg p-2 bg-white">
                                <img src="" alt="Preview Logo Baru" id="previewImg" class="w-24 h-24 object-contain">
                            </div>
                            <div>
                                <p class="text-sm text-green-600 font-medium mb-2">Preview Logo Baru</p>
                                <button type="button" onclick="clearLogoPreview()"
                                        class="text-sm text-red-600 hover:text-red-800">
                                    Batalkan
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="file" name="company_logo" id="company_logo" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           onchange="previewLogo(event)">
                    <p class="text-sm text-gray-500 mt-1">Format: PNG, JPG, JPEG. Max: 2MB. Rekomendasi: 500x500px</p>
                </div>

                <!-- Preview Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-800 font-medium">Informasi</p>
                            <p class="text-sm text-blue-700">Logo akan otomatis muncul di tengah QR Code yang di-generate. QR Code tetap dapat di-scan meskipun ada logo di tengahnya.</p>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-blue-700 transition">
                    Simpan Pengaturan
                </button>
            </form>
        </div>
    </main>
</div>

<script>
// Preview logo sebelum upload
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('newLogoPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Clear preview logo
function clearLogoPreview() {
    document.getElementById('company_logo').value = '';
    document.getElementById('newLogoPreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
}

// Delete logo
function deleteLogo() {
    if (confirm('Yakin ingin menghapus logo?')) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.settings.delete-logo') }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add DELETE method
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        // Append to body and submit
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
