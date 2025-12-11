@extends('layouts.app')

@section('title', 'Kelola QR Code')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Kelola QR Code</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    Dashboard
                </a>
                <a href="{{ route('admin.settings') }}"
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Pengaturan
                </a>
                <div class="flex items-center gap-3">
                    @if($user && $user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                             alt="{{ session('admin_name') }}"
                             class="w-10 h-10 rounded-full object-cover border-2 border-gray-300">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-300">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ session('admin_name') }}</p>
                        <a href="{{ route('admin.profile') }}" class="text-xs text-blue-600 hover:text-blue-800">Edit Profil</a>
                    </div>
                </div>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <form method="POST" action="{{ route('admin.qrcodes.generate') }}">
                @csrf
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    Generate QR Code Baru
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Daftar QR Code</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @forelse($qrCodes as $qr)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex justify-center mb-4">
                        <img src="{{ route('admin.qrcodes.show', $qr->token) }}"
                             alt="QR Code"
                             class="w-48 h-48">
                    </div>
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">URL:</p>
                        <p class="text-sm text-gray-700 break-all">{{ $qr->url }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Dibuat:</p>
                        <p class="text-sm text-gray-700">{{ $qr->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.qrcodes.download', $qr->token) }}"
                           class="flex-1 bg-green-600 text-white px-4 py-2 rounded text-center hover:bg-green-700 transition text-sm">
                            Download
                        </a>
                        <button onclick="printQR('{{ route('admin.qrcodes.show', $qr->token) }}')"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                            Print
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    Belum ada QR Code. Klik tombol "Generate QR Code Baru" untuk membuat.
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
function printQR(imageUrl) {
    const win = window.open('', '_blank');
    win.document.write(`
        <html>
        <head>
            <title>Print QR Code</title>
            <style>
                body { margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
                img { max-width: 100%; height: auto; }
            </style>
        </head>
        <body>
            <img src="${imageUrl}" onload="window.print(); window.close();">
        </body>
        </html>
    `);
    win.document.close();
}
</script>
@endpush
@endsection
