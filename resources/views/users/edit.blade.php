<x-app-layout>
    <div class="mx-auto max-w-3xl p-6">
        <h1 class="mb-6 text-2xl font-semibold">Edit user</h1>

        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @include('users.form', ['user' => $user])

            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white">
                Perbarui
            </button>
        </form>
    </div>
</x-app-layout>