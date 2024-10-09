<?php

use App\Enums\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FolderController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\PermissionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(FolderController::class)->middleware('auth:api')->group(function () {

    Route::prefix('folder')->group(function () {
        Route::post('/store', 'store')->middleware('permission:' . Permission::CREATE_FOLDER->value);
        Route::put('/update/{folder_id}', 'update')->middleware('permission:' . Permission::UPDATE_FOLDER->value);
        Route::delete('/delete/{folder_id}', 'destroy')->middleware('permission:' . Permission::DELETE_FOLDER->value);
        Route::get('/get/{folder_id}', 'getFolderChildren')->middleware('permission:' . Permission::GET_FOLDER_CHILDREN->value);
    });
});

Route::controller(FileController::class)->middleware('auth:api')->group(function () {

    Route::prefix('file')->group(function () {
        Route::post('/store', 'store')->middleware('permission:' . Permission::CREATE_FILE->value);
        Route::put('/update/{file_id}', 'update')->middleware('permission:' . Permission::UPDATE_FILE->value);
        Route::delete('/delete/{file_id}', 'destroy')->middleware('permission:' . Permission::DELETE_FILE->value);
    });
});

Route::controller(UserController::class)->group(function () {

    Route::prefix('user')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
});

Route::middleware('auth:api')->get('/user/logout', [UserController::class, 'logout']);


Route::controller(RoleController::class)->middleware('auth:api')->group(function () {
    Route::prefix('roles')->group(function () {
        Route::post('/', 'store')->middleware('permission:' . Permission::ADD_ROLE->value);
        Route::get('/', 'index')->middleware('permission:' . Permission::VIEW_ROLES->value);

        Route::post('/{role_id}/permissions', 'addPermissionsToRole')->middleware('permission:' . Permission::ADD_PERMISSIONS_TO_ROLE->value);
        Route::post('/{role_id}/users/{user_id}', 'addRoleToUser')->middleware('permission:' . Permission::ADD_ROLE_TO_USER->value);
    });
});

Route::controller(PermissionController::class)->middleware('auth:api')->group(function () {
    Route::prefix('permissions')->group(function () {
        Route::get('/', 'index')->middleware('permission:' . Permission::VIEW_PERMISSIONS->value);
    });
});

Route::get('/search/{name}', [FolderController::class, 'search'])->middleware('permission:' . Permission::SEARCH->value);