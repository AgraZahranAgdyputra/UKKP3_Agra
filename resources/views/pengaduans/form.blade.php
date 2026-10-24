<div class="space-y-5">
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select id="kategori" name="kategori" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Pilih kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->nama }}"
                    @selected(old('kategori', $pengaduan?->kategori) === $kategori->nama)>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>
        @error('kategori')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
        <input id="nama_perusahaan" name="nama_perusahaan" type="text" maxlength="255"
               value="{{ old('nama_perusahaan', $pengaduan?->nama_perusahaan) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('nama_perusahaan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
        <input id="lokasi" name="lokasi" type="text" required maxlength="255"
               value="{{ old('lokasi', $pengaduan?->lokasi) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('lokasi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
        <input id="judul" name="judul" type="text" required maxlength="255"
               value="{{ old('judul', $pengaduan?->judul) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('judul')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required maxlength="10000"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $pengaduan?->deskripsi) }}</textarea>
        @error('deskripsi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
        <input id="nama" type="text" value="{{ $pengaduan?->nama ?? auth()->user()->name }}" readonly
               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" type="email" value="{{ $pengaduan?->email ?? auth()->user()->email }}" readonly
               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
    </div>

    <div>
        <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
        <input id="no_hp" name="no_hp" type="text" required maxlength="20"
               value="{{ old('no_hp', $pengaduan?->no_hp) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('no_hp')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="upload_file" class="block text-sm font-medium text-gray-700">Lampiran (opsional)</label>
        <input id="upload_file" name="upload_file" type="file" accept=".jpg,.jpeg,.png,.pdf"
               class="mt-1 block w-full text-sm text-gray-700">
        <p class="mt-1 text-sm text-gray-500">Format JPG, JPEG, PNG, atau PDF; maksimal 2 MB.</p>
        @error('upload_file')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @if ($pengaduan?->upload_file)
            <p class="mt-2 text-sm text-gray-600">Lampiran saat ini: {{ basename($pengaduan->upload_file) }}</p>
        @endif
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            {{ $pengaduan ? 'Simpan Perubahan' : 'Kirim Pengaduan' }}
        </button>
        <a href="{{ route('pengaduans.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</div>
