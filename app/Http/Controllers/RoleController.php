<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), (new RoleRequest())->rules());

            if($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $role = Role::create($request->only('name'));

            return response()->json(new RoleResource($role), 201);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function index()
    {
        return Role::all();
    }

    public function addPermissionsToRole(Request $request, $role_id)
    {
        $role = Role::find($role_id);

        $role->syncPermissions(collect($request->all())->pluck('id'));

        return response()->json([
            "message" => "success"
        ]);
    }

    public function addRoleToUser(Request $request, $role_id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $role = Role::findOrFail($role_id);

        $user->assignRole($role);

        return response()->json([
            "message" => "success"
        ]);
    }
}
