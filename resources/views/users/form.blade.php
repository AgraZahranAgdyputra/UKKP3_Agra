<div class="space-y-4">
    <div>
        <label for="name">Nama</label>
        <input
            id="name"
            name="name"
            value="{{ old('name', $user?->name) }}"
            required
            class="mt-1 block w-full rounded-md border-gray-300"
        >
        @error('name')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email', $user?->email) }}"
            required
            class="mt-1 block w-full rounded-md border-gray-300"
        >
        @error('email')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="role">Roles</label>
        <select id="role" name="role" required>
            <option value="">Pilih role</option>

        @foreach ($roles as $role)
            <option
                value="{{ $role }}"
                @selected(old('role', $user?->getRoleNames()->first() ?? '') === $role)
            >
                {{ ucfirst($role) }}
            </option>
        @endforeach
        </select>

        @error('role')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

    </div>

    <div>
        <label for="password">Password</label>
        <input
            id="password"
            type="password"
            name="password"
            {{ $user ? '' : 'required' }}
            class="mt-1 block w-full rounded-md border-gray-300"
        >

        @if ($user)
            <p class="text-sm text-gray-600">
                Kosongkan jika tidak ingin mengubah password.
            </p>
        @endif

        @error('password')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation">Konfirmasi password</label>
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            {{ $user ? '' : 'required' }}
            class="mt-1 block w-full rounded-md border-gray-300"
        >
    </div>
</div>