<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori') }}
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <p class="text-gray-600">Kategori tersedia untuk form pengaduan.</p>
                <a href="{{ route('kategoris.create') }}"
                   class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                    Tambah Kategori
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-red-800">{{ session('error') }}</div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                @forelse ($kategoris as $kategori)
                    <div class="flex items-center justify-between border-b border-gray-200 p-4 last:border-b-0">
                        <span class="font-medium text-gray-900">{{ $kategori->nama }}</span>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('kategoris.edit', $kategori) }}"
                               class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Edit</a>
                            <form method="POST" action="{{ route('kategoris.destroy', $kategori) }}"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-gray-600">Belum ada kategori. Tambahkan kategori agar muncul di form pengaduan.</p>
                @endforelse
            </div>
        </div>
    </main>
</x-app-layout>
