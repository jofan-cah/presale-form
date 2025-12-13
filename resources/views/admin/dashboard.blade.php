@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.qrcodes') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Kelola QR Code
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
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Data Form Presale</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor HP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Follow Up</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($submissions as $index => $submission)
                        <tr class="hover:bg-gray-50 transition-colors" id="row-{{ $submission->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $submission->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $submission->nomor_hp) }}"
                                   target="_blank"
                                   class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    {{ $submission->nomor_hp }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $submission->alamat }}">{{ $submission->alamat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $submission->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button onclick="toggleFollowUp({{ $submission->id }})"
                                        id="btn-{{ $submission->id }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all {{ $submission->is_followed_up ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($submission->is_followed_up)
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    <span id="text-{{ $submission->id }}">{{ $submission->is_followed_up ? 'Sudah Follow Up' : 'Belum Follow Up' }}</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada data submission
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
function toggleFollowUp(submissionId) {
    const btn = document.getElementById(`btn-${submissionId}`);
    const text = document.getElementById(`text-${submissionId}`);

    // Disable button sementara
    btn.disabled = true;
    btn.style.opacity = '0.6';

    fetch(`/admin/submissions/${submissionId}/toggle-follow-up`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button styling
            if (data.is_followed_up) {
                btn.className = 'inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all bg-green-100 text-green-800 hover:bg-green-200';
                text.textContent = 'Sudah Follow Up';
                // Update icon
                btn.querySelector('svg').innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
            } else {
                btn.className = 'inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
                text.textContent = 'Belum Follow Up';
                // Update icon
                btn.querySelector('svg').innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>';
            }

            // Show toast notification
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${type === 'success' ? 'bg-green-600' : 'bg-red-600'} animate-slide-up`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slide-up {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-slide-up {
    animation: slide-up 0.3s ease-out;
}
</style>
@endsection
