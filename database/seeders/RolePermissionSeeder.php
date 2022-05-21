<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name'       => UserRole::SUPERADMIN,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => UserRole::ADMIN,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => UserRole::SHOPMANAGER,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => UserRole::AFFILIATE,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => UserRole::CUSTOMER,
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);

        // Super Admin
        $role = Role::find(1);
        $user = User::find(1);
        if (!blank($user) && !blank($role)) {
            $user->assignRole($role->name);
        }

        // Admin
        $role = Role::find(2);
        $user = User::find(2);
        if (!blank($user) && !blank($role)) {
            $user->assignRole($role->name);
        }

        // Shop Manager
        $mrole = Role::find(3);
        $muser = User::find(3);
        if (!blank($muser) && !blank($mrole)) {
            $muser->assignRole($mrole->name);
        }

        // Affiliate
        $arole = Role::find(4);
        $auser = User::find(4);
        if (!blank($auser) && !blank($arole)) {
            $auser->assignRole($arole->name);
        }

        // Customer
        $crole = Role::find(5);
        $cuser = User::find(5);
        if (!blank($cuser) && !blank($crole)) {
            $cuser->assignRole($crole->name);
        }
    }
}
