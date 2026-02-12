<?php

namespace App\Http\Controllers;

use App\Models\DaftarMemoriTelepon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    //
    public function index()
    {
        try {
            if (request()->ajax()) {
                $start = request()->input('start', 0);
                $length = request()->input('length', 10);

                $query = DaftarMemoriTelepon::query();

                // Pencarian
                if (request()->has('search') && !empty(request()->search['value'])) {
                    $searchValue = request()->search['value'];
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('memori', 'like', "%{$searchValue}%")
                            ->orWhere('nama', 'like', "%{$searchValue}%");
                    });
                }

                // Sorting
                if (request()->has('order') && !empty(request()->order)) {
                    $columnIndex = request()->order[0]['column'];
                    $columnData = request()->columns[$columnIndex]['data'];
                    $direction = request()->order[0]['dir'];
                    
                    if ($columnData && $columnData != 'no') {
                        $query->orderBy($columnData, $direction);
                    } else {
                        $query->orderBy('id', 'desc');
                    }
                } else {
                    $query->orderBy('id', 'desc');
                }

                $recordsTotal = DaftarMemoriTelepon::count();
                $recordsFiltered = $query->count();

                if ($length != -1) {
                    $data = $query->offset($start)->limit($length)->get();
                } else {
                    $data = $query->get();
                }

                return response()->json([
                    'draw' => intval(request()->input('draw')),
                    'recordsTotal' => $recordsTotal,
                    'recordsFiltered' => $recordsFiltered,
                    'data' => $data
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('SuperAdminController AJAX error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return view('super_admin.super_admin_memori');
    }

    public function storeMemori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'memori' => 'string|max:255',
            'nama' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        $extension = DaftarMemoriTelepon::create([
            'memori' => $request->memori,
            'nama' => $request->nama,
        ]);

        return response()->json([
            'success' => 'Memori added successfully',
            'status' => 200,
            'data' => $extension
        ]);
    }

    public function editExtension($id)
    {
        $extension = DaftarMemoriTelepon::find($id);
        return response()->json($extension, 200);
    }

    public function updateExtension(Request $request, $id)
    {
        $extension = DaftarMemoriTelepon::find($id);
        $extension->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Extension updated successfully',
        ]);
    }

    public function destroyExtension($id)
    {
        $extension = DaftarMemoriTelepon::find($id);
        $extension->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Extension deleted successfully',
        ]);
    }
}
