<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permissionNames = [
            'pengaduan.view',
            'pengaduan.view.all',
            'pengaduan.create',
            'pengaduan.update',
            'pengaduan.delete',
            'kategori.manage',
            'user.manage',
            'dashboard.view',
        ];

        $permissions = collect($permissionNames)->map(
            fn (string $name) => Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ])
        );

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $customer = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions($permissions);
        $customer->syncPermissions([
            'pengaduan.view',
            'pengaduan.create',
            'pengaduan.update',
        ]);

        app(\Spatie\Permission\PermissionRegistrar::class)
            ->forgetCachedPermissions();
    }
}