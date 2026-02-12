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
        try {
            if (request()->ajax()) {
                $start = request()->input('start', 0);
                $length = request()->input('length', 10);

                $query = DaftarExtension::query();

                // Pencarian
                if (request()->has('search') && !empty(request()->search['value'])) {
                    $searchValue = request()->search['value'];
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('ext', 'like', "%{$searchValue}%")
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

                $recordsTotal = DaftarExtension::count();
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
            \Log::error('HumasController Extension AJAX error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return view('humas.humas');
    }

    public function dokter()
    {
        try {
            if (request()->ajax()) {
                $start = request()->input('start', 0);
                $length = request()->input('length', 10);

                $query = Dokter::query();

                // Pencarian (Hanya Nama karena nomor_hp adalah array/JSON)
                if (request()->has('search') && !empty(request()->search['value'])) {
                    $searchValue = request()->search['value'];
                    $query->where('nama', 'like', "%{$searchValue}%");
                }

                // Sorting
                if (request()->has('order') && !empty(request()->order)) {
                    $columnIndex = request()->order[0]['column'];
                    $columnData = request()->columns[$columnIndex]['data'];
                    $direction = request()->order[0]['dir'];
                    
                    if ($columnData && !in_array($columnData, ['no', 'nomor_hp'])) {
                        $query->orderBy($columnData, $direction);
                    } else {
                        $query->orderBy('id', 'desc');
                    }
                } else {
                    $query->orderBy('id', 'desc');
                }

                $recordsTotal = Dokter::count();
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
            \Log::error('HumasController Dokter AJAX error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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
