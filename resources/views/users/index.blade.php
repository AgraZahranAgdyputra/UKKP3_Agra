<x-app-layout>
    <div class="mx-auto max-w-7xl p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Kelola user</h1>

            <a href="{{ route('users.create') }}"
               class="rounded bg-blue-600 px-4 py-2 text-white">
                Tambah user
            </a>
        </div>

        @if (session('status'))
            <p class="mb-4 text-green-700">{{ session('status') }}</p>
        @endif

        @error('user')
            <p class="mb-4 text-red-600">{{ $message }}</p>
        @enderror

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="w-full text-left">
                <thead class="bg-[#470000]">
                    <tr class="border-b text-white">
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">{{ $user->getRoleNames()->implode(', ') ?: 'gada role' }}</td>
                            <td class="p-3">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="text-blue-600">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('users.destroy', $user) }}"
                                    class="ml-3 inline"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-3">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>