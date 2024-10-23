<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            $employee = Employee::query()->findOrFail($id);

            return response()->json([
                'massage' => 'Thanh cong',
                'data'    => $employee
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());




            if ($th instanceof ModelNotFoundException) {
                return response()->json([
                    'massage' => 'Not Found',
                ], Response::HTTP_NOT_FOUND);
            }


            return response()->json([
                'massage' => 'Server error',

            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {

        $data = $request->validated();

        try {
            $employee = Employee::query()->findOrFail($id);

            $data['is_active'] ??= 0;

            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('images', $request->file('image'));
            }
            $imgCurrentPath = $employee->image;

            $employee->update($data);

            if (!empty($data['image']) && $imgCurrentPath && Storage::exists($imgCurrentPath)) {
                Storage::delete($imgCurrentPath);
            }

            return response()->json([
                'massage' => 'Update Thanh cong',
                'data'    => $employee
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            if (!empty($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }

            if ($th instanceof ModelNotFoundException) {
                return response()->json([
                    'massage' => 'Not Found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'massage' => 'Server error',

            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = Employee::query()->findOrFail($id);

            $imgCurrent = $employee->image;

            $employee->delete();

            if (!empty($imgCurrent) && Storage::exists($imgCurrent)) {
                Storage::delete($imgCurrent);
            }

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            if ($th instanceof ModelNotFoundException) {
                return response()->json([
                    'massage' => 'Not Found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'massage' => 'Server error',

            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
