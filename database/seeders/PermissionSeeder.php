<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'blog-create',
            'blog-read',
            'blog-update',
            'blog-delete',

            'income-create',
            'income-read',
            'income-update',
            'income-delete',

            'expense-create',
            'expense-read',
            'expense-update',
            'expense-delete',

            'internal-user-create',
            'internal-user-read',
            'internal-user-update',
            'internal-user-delete',

            'public-user-create',
            'public-user-read',
            'public-user-update',
            'public-user-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
