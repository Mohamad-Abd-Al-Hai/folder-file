<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\File;
use App\Models\Folder;
use App\Enums\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\FolderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\FolderResource;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), (new FolderRequest())->rules());

            if($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $folder = Folder::create($request->only('name', 'parent_folder_id'));

            return response()->json(new FolderResource($folder), 201);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), (new FolderRequest())->rules());

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $folder = Folder::findOrFail($id);
        $folder->update($request->only('name', 'parent_folder_id'));

        return new FolderResource($folder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();

        return response()->json(['message' => 'success']);
    }

    /**
     * Get all of the folder's children (folders and files).
     */
    public function getFolderChildren(string $id) 
    {
        return Folder::with(['folders', 'files'])->find($id);
    }

    public function search(Request $request, $name)
    {
        $results1 = Folder::select('id', 'name as folder', 'parent_folder_id')->where('name', 'like', '%' . $name . '%')->get();

        $results2 = File::select('id', 'name as file', 'parent_folder_id')->where('name', 'like', '%' . $name . '%')->get();

        $combinedResults = $results1->merge($results2)->toArray();

        return response()->json(["data" => $combinedResults]);
    }
}
