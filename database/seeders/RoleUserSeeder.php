<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['administrator', 'finance', 'supervisor', 'editor', 'user'];
        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role], []);
        }
        $this->setRoleAdministrator();
        $this->setRoleEditor();
        $this->setRoleFinance();
        $this->setRoleSupervisor();
        $this->createAdmin();
    }

    public function createAdmin()
    {
        $admin = [
            'name'              => 'Hairul Anam',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password'          => bcrypt('administrator'),
            // 'profile_picture',
            'address'      => 'Jember, Jawa Timur',
            'phone_number' => '085322778935',
            // 'remember_token',
        ];
        $user = User::updateOrCreate([
            'email' => 'hairulanam21@gmail.com',
        ], $admin);
        $user->assignRole('administrator');
    }

    public function setRoleAdministrator()
    {
        $role        = Role::where('name', 'administrator')->first();
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }

    public function setRoleFinance()
    {
        $role        = Role::where('name', 'finance')->first();
        $permissions = Permission::where('name', 'like', 'expense-%')->get();
        $role->syncPermissions($permissions);
        $permissions = Permission::where('name', 'like', 'income-%')->get();
        $role->syncPermissions($permissions);
    }

    public function setRoleEditor()
    {
        $role        = Role::where('name', 'editor')->first();
        $permissions = Permission::where('name', 'like', 'blog-%')->get();
        $role->syncPermissions($permissions);
    }

    public function setRoleSupervisor()
    {
        # ini gak tau apa ya permissionnya? di pdf tidak ada informasinya
        // $role        = Role::where('name', 'supervisor')->first();
        // $permissions = Permission::where('name', 'like', 'blog-%')->get();
        // $role->syncPermissions($permissions);
    }
}
