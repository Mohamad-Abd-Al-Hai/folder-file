<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\Permission;
use App\Enums\Role as RoleEnum;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Permission::cases() as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission->value , 'guard_name' => 'api']);
        }

        foreach (RoleEnum::cases() as $role) {
            $role = Role::create(['name' => $role->value , 'guard_name' => 'api']);

            $this->syncPermissionsToRole($role);
        }
    }

    public function syncPermissionsToRole(Role $role)
    {
        $permissions = [];

        switch ($role->name) {
            case RoleEnum::ADMIN->value:
                $permissions = [
                    Permission::CREATE_FOLDER,
                    Permission::UPDATE_FOLDER,
                    Permission::GET_FOLDER_CHILDREN,
                    Permission::DELETE_FOLDER,
                    Permission::CREATE_FILE,
                    Permission::UPDATE_FILE,
                    Permission::DELETE_FILE,
                    Permission::VIEW_PERMISSIONS,
                    Permission::VIEW_ROLES,
                    Permission::ADD_PERMISSIONS_TO_ROLE,
                    Permission::ADD_ROLE_TO_USER,
                    Permission::ADD_ROLE,
                    Permission::SEARCH
                ];
                break;
            case RoleEnum::MEMBER->value:
                $permissions = [
                    Permission::CREATE_FILE,
                    Permission::UPDATE_FILE,
                ];
                break;
        }

        $role->syncPermissions($permissions);
    }
}
