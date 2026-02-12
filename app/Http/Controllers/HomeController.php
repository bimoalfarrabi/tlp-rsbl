<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DaftarExtension;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $start = request()->start ?? 0;
            $length = request()->length ?? 10;

            $query = DaftarExtension::query();

            // Pencarian
            if (request()->has('search') && request()->search['value'] != '') {
                $searchValue = request()->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('ext', 'like', "%{$searchValue}%")
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
                'recordsTotal' => DaftarExtension::count(),
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
        }

        return view('admin.dashboard_admin');
    }

    public function storeExtension(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ext' => 'string|max:255',
            'nama' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        $extension = DaftarExtension::create([
            'ext' => $request->ext,
            'nama' => $request->nama,
        ]);

        return response()->json([
            'success' => 'Extension added successfully',
            'status' => 200,
            'data' => $extension
        ]);
    }

    public function editExtension($id)
    {
        $extension = DaftarExtension::find($id);
        return response()->json($extension, 200);
    }

    public function updateExtension(Request $request, $id)
    {
        $extension = DaftarExtension::find($id);
        $extension->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Extension updated successfully',
        ]);
    }

    public function destroyExtension($id)
    {
        $extension = DaftarExtension::find($id);
        $extension->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Extension deleted successfully',
        ]);
    }
}
