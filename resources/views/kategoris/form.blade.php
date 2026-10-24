<div class="space-y-5">
    <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
        <input id="nama" name="nama" type="text" required maxlength="255"
               value="{{ old('nama', $kategori->nama ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('nama')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            Simpan
        </button>
        <a href="{{ route('kategoris.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</div>
