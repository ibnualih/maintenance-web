<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Buat roles
        $admin = Role::updateOrCreate(['name' => 'admin']);
        $supervisor = Role::updateOrCreate(['name' => 'supervisor']);
        $mekanik = Role::updateOrCreate(['name' => 'mekanik']);

        // Buat permissions
        $permissions = [
            'view user',
            'create user',
            'edit user',
            'delete user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Sinkronkan permissions dengan roles
        $admin->syncPermissions(Permission::pluck('name'));
        $supervisor->syncPermissions(['view user', 'create user', 'edit user']);
        // $mekanik->syncPermissions(['view user']);

        // Tetapkan role ke pengguna
        $users = [
            1 => 'admin',
            2 => 'supervisor',
            3 => 'mekanik',
        ];

        foreach ($users as $id => $roleName) {
            $user = User::find($id);
            if ($user && Role::where('name', $roleName)->exists()) {
                $user->syncRoles([$roleName]);
            }
        }
    }
}
