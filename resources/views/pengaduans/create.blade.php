<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pengaduan') }}
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('pengaduans.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('pengaduans.form', ['pengaduan' => null, 'kategoris' => $kategoris])
                </form>
            </div>
        </div>
    </main>
</x-app-layout>
