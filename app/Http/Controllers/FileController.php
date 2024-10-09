<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), (new FileRequest())->rules());

            if($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $file = File::create($request->only('name', 'parent_folder_id'));

            return response()->json(new FileResource($file), 201);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), (new FileRequest())->rules());

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = File::find($id);
        $file->update($request->only('name', 'parent_folder_id'));

        return new FileResource($file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return response()->json(['message' => 'success']);
    }
}
