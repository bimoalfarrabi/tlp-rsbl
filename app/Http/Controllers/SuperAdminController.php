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
        if (request()->ajax()) {
            $start = request()->start ?? 0;
            $length = request()->length ?? 10;

            $query = DaftarMemoriTelepon::query();

            // Pencarian
            if (request()->has('search') && request()->search['value'] != '') {
                $searchValue = request()->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('memori', 'like', "%{$searchValue}%")
                        ->orWhere('nama', 'like', "%{$searchValue}%");
                });
            }

            // Sorting
            if (request()->has('order')) {
                foreach (request()->order as $order) {
                    $columnIndex = $order['column'];
                    $columnName = request()->columns[$columnIndex]['data'];

                    // Handling khusus untuk kolom nomor urut
                    if ($columnName === 'id') {
                        $direction = $order['dir'];
                        $query->orderBy('id', $direction);
                    } else {
                        $direction = $order['dir'];
                        $query->orderBy($columnName, $direction);
                    }
                }
            }

            // Total records sebelum pagination
            $totalRecords = $query->count();

            // Pagination manual
            if ($length == -1) {
                $data = $query->get(); // Ambil semua data jika length adalah -1
            } else {
                $data = $query->offset($start)
                    ->limit($length)
                    ->get();
            }

            return response()->json([
                'draw' => intval(request()->draw),
                'recordsTotal' => DaftarMemoriTelepon::count(),
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
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
