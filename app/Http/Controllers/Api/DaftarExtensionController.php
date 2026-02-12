<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarExtension;

class DaftarExtensionController extends Controller
{
    // GET /api/extensions → semua data
    public function index()
    {
        $data = DaftarExtension::all();

        return response()->json($data);
    }

    // (opsional) GET /api/extensions/{id} → satu data
    public function show($id)
    {
        $data = DaftarExtension::findOrFail($id);

        return response()->json($data);
    }
}
