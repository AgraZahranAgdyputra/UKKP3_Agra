<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lampiran Pengaduan') }}
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <p class="text-sm text-gray-600">Nama: <strong>{{ $pengaduan->nama }}</strong></p>
                    <p class="text-sm text-gray-600">Kategori: <strong>{{ $pengaduan->kategori }}</strong></p>
                    <p class="text-sm text-gray-600">Perusahaan: <strong>{{ $pengaduan->nama_perusahaan }}</strong></p>
                    <p class="text-sm text-gray-600">Lokasi: <strong>{{ $pengaduan->lokasi }}</strong></p>
                    <p class="text-sm text-gray-600">Judul: <strong>{{ $pengaduan->judul }}</strong></p>
                    <p class="mt-2 whitespace-pre-line text-sm text-gray-700">{{ $pengaduan->deskripsi }}</p>
                </div>

                @if ($pengaduan->upload_file)
                    @php
                        $fileUrl = url('/storage/'.$pengaduan->upload_file);
                        $extension = strtolower(pathinfo($pengaduan->upload_file, PATHINFO_EXTENSION));
                    @endphp

                    @if (in_array($extension, ['jpg', 'jpeg', 'png'], true))
                        <a href="{{ $fileUrl }}" target="_blank" rel="noopener">
                            <img src="{{ $fileUrl }}" alt="Lampiran pengaduan"
                                 class="mx-auto max-h-[70vh] rounded-md object-contain">
                        </a>
                    @else
                        <p class="text-gray-700">Lampiran PDF:</p>
                        <a href="{{ $fileUrl }}" target="_blank" rel="noopener"
                           class="mt-2 inline-block text-indigo-600 underline">
                            Buka lampiran
                        </a>
                    @endif
                @else
                    <p class="text-gray-600">Pengaduan ini belum memiliki lampiran.</p>
                @endif

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('pengaduans.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Kembali ke daftar
                    </a>
                    <a href="{{ route('pengaduans.edit', $pengaduan) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                        Edit pengaduan
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
