<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\DaftarExtension;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class HumasController extends Controller
{
    public function index() // untuk datatable extension
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

        return view('humas.humas');
    }

    public function dokter()
    {
        if (request()->ajax()) {
            $start = request()->start ?? 0;
            $length = request()->length ?? 10;

            Log::info('Search Value: ' . request()->search['value']);
            $query = Dokter::query();

            // Pencarian
            if (request()->has('search') && request()->search['value'] != '') {
                $searchValue = request()->search['value'];
                $query->where(function ($q) use ($searchValue) {
                    $q->where('nama', 'like', "%{$searchValue}%")
                        ->orWhere('nomor_hp', 'like', "%{$searchValue}%");
                });
            }

            // Sorting
            if (request()->has('order')) {
                foreach (request()->order as $order) {
                    $columnIndex = $order['column'];
                    $columnName = request()->columns[$columnIndex]['data'];

                    $direction = $order['dir'];
                    $query->orderBy($columnName, $direction);
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
                'recordsTotal' => Dokter::count(),
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
        }

        return view('humas.humas_dokter');
    }

    public function storeDokter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'nullable|array',
            'nomor_hp.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        $nomor_hp = $request->input('nomor_hp', []);
        $nomor_hp = array_filter($nomor_hp, function ($value) {
            return !empty(trim($value));
        });

        $dokter = Dokter::create([
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp ?? [],
        ]);

        return response()->json([
            'success' => 'Dokter added successfully',
            'status' => 200,
            'data' => $dokter
        ]);
    }

    public function editDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        return response()->json($dokter, 200);
    }

    public function updateDokter(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        $dokter = Dokter::find($id);
        $dokter->update([
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp ?? [],
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Dokter updated successfully',
        ]);
    }

    public function destroyDokter($id)
    {
        $dokter = Dokter::find($id);
        $dokter->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Dokter deleted successfully',
        ]);
    }
}
