<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengaduan') }}
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <p class="text-gray-600">Daftar pengaduan yang telah masuk.</p>
                @can('pengaduan.create')
                    <a href="{{ route('pengaduans.create') }}"
                       class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Tambah Pengaduan
                    </a>
                @endcan
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($pengaduans as $pengaduan)
                <article class="mb-4 rounded-lg bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $pengaduan->kategori }}</h3>
                            <p class="mt-1 font-medium text-gray-800">{{ $pengaduan->judul }}</p>
                            <p class="text-sm text-gray-600">{{ $pengaduan->nama_perusahaan }} · {{ $pengaduan->lokasi }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $pengaduan->nama }}</p>
                            <p class="text-sm text-gray-600">{{ $pengaduan->email }} · {{ $pengaduan->no_hp }}</p>
                            <p class="mt-2 whitespace-pre-line text-gray-700">{{ $pengaduan->deskripsi }}</p>
                            <p class="mt-2 text-sm text-gray-500">
                                {{ $pengaduan->created_at?->format('d/m/Y') }}
                            </p>
                            @if ($pengaduan->upload_file)
                                <a class="mt-2 inline-block text-sm text-indigo-600 underline"
                                   href="{{ route('pengaduans.photos', $pengaduan) }}">
                                    Lihat lampiran
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            @can('pengaduan.update')
                                <a href="{{ route('pengaduans.edit', $pengaduan) }}"
                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                    Edit
                                </a>
                            @endcan
                            @can('pengaduan.delete')
                                <form method="POST" action="{{ route('pengaduans.destroy', $pengaduan) }}"
                                      onsubmit="return confirm('Hapus pengaduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg bg-white p-6 text-gray-600 shadow-sm">
                    Belum ada pengaduan.
                </div>
            @endforelse
        </div>
    </main>
</x-app-layout>
