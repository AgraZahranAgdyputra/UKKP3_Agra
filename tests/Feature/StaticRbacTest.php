<?php

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();
    (new RolePermissionSeeder())->run();
});

test('customer can access complaint features but not administration pages', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $this->actingAs($customer)
        ->get(route('pengaduans.index'))
        ->assertOk();

    $this->get(route('pengaduans.create'))
        ->assertOk();

    $this->get(route('users.index'))
        ->assertForbidden();

    $this->get(route('kategoris.index'))
        ->assertForbidden();

    $this->get(route('dashboard'))
        ->assertRedirect(route('pengaduans.index'));
});

test('customer can view and edit only their own complaints', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $ownComplaint = Pengaduan::create([
        'kategori' => 'Umum',
        'upload_file' => 'pengaduans/milik-customer.pdf',
        'nama' => $customer->name,
        'email' => $customer->email,
        'no_hp' => '081234567890',
        'judul' => 'Pengaduan saya',
    ]);

    $otherComplaint = Pengaduan::create([
        'kategori' => 'Umum',
        'nama' => 'Pengguna lain',
        'email' => 'other@example.com',
        'no_hp' => '081234567891',
        'judul' => 'Pengaduan orang lain',
    ]);

    Storage::disk('local')->put('pengaduans/milik-customer.pdf', 'file content');

    $this->actingAs($customer)
        ->get(route('pengaduans.edit', $ownComplaint))
        ->assertOk();

    $this->get(route('pengaduans.file', $ownComplaint))
        ->assertOk();

    $this->get(route('pengaduans.index'))
        ->assertOk()
        ->assertSee('Pengaduan saya')
        ->assertDontSee('Pengaduan orang lain');

    $this->get(route('pengaduans.edit', $otherComplaint))
        ->assertForbidden();

    $this->get(route('pengaduans.photos', $otherComplaint))
        ->assertForbidden();

    $this->get(route('pengaduans.file', $otherComplaint))
        ->assertForbidden();

    Kategori::create(['nama' => 'Umum']);

    $this->put(route('pengaduans.update', $ownComplaint), [
        'kategori' => 'Umum',
        'nama_perusahaan' => '',
        'lokasi' => 'Jakarta',
        'judul' => 'Judul setelah diedit',
        'deskripsi' => 'Deskripsi',
        'no_hp' => '081234567890',
    ])->assertRedirect(route('pengaduans.index'));

    expect($ownComplaint->fresh()->judul)->toBe('Judul setelah diedit');
});

test('admin can access user and category management and see all complaints', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    Pengaduan::create([
        'kategori' => 'Umum',
        'nama' => 'Customer',
        'email' => 'customer@example.com',
        'no_hp' => '081234567890',
        'judul' => 'Pengaduan customer',
    ]);

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk();

    $this->get(route('kategoris.index'))
        ->assertOk();

    $this->get(route('pengaduans.index'))
        ->assertOk()
        ->assertSee('Pengaduan customer');

    $this->get(route('dashboard'))
        ->assertOk();
});

test('customer cannot delete a complaint', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $complaint = Pengaduan::create([
        'kategori' => 'Umum',
        'nama' => $customer->name,
        'email' => $customer->email,
        'no_hp' => '081234567890',
        'judul' => 'Pengaduan saya',
    ]);

    $this->actingAs($customer)
        ->delete(route('pengaduans.destroy', $complaint))
        ->assertForbidden();

    $this->assertDatabaseHas('pengaduans', ['id' => $complaint->id]);
});
