<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\Permission;

class FolderPolicy
{
    public function createFolder(User $user): bool
    {
        print("police");
        return $user->hasPermissionTo(Permission::CREATE_FOLDER);
    }
}
