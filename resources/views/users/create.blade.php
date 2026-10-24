<x-app-layout>
    <div class="mx-auto max-w-3xl p-6">
        <h1 class="mb-6 text-2xl font-semibold">Tambah user</h1>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            @include('users.form', ['user' => null])

            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>