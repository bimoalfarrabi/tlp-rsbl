<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarExtension;
use App\Models\DaftarMemoriTelepon;
use App\Models\Dokter;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function index() //data extension
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

        return view('guest_page');
    }

    public function daftarMemoriTelepon()
    {
        try {
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
                    $columnIndex = request()->order[0]['column'];
                    $columnName = request()->columns[$columnIndex]['data'];
                    $direction = request()->order[0]['dir'];

                    // Pastikan kolom yang diurutkan valid
                    $allowedColumns = ['memori', 'nama'];
                    if (in_array($columnName, $allowedColumns)) {
                        $query->orderBy($columnName, $direction);
                    }
                }

                // Total records sebelum pagination
                $totalRecords = $query->count();

                // Pagination
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

            // Jika bukan ajax, tampilkan view
            return view('guest_page_memori_telepon');
        } catch (\Exception $e) {
            // Tangani error
            Log::error('Error in daftarMemoriTelepon: ' . $e->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportpdf()
    {
        $allExtensions = DaftarExtension::all();
        $half = ceil($allExtensions->count() / 2);

        // Bagi data menjadi dua bagian
        $leftTableData = $allExtensions->take($half);
        $rightTableData = $allExtensions->slice($half);

        return view('PDF.export', compact('leftTableData', 'rightTableData'));
    }
    public function exportpdf2()
    {
        // Menggunakan raw DB untuk menghapus tanda '*' dan mengurutkan sebagai integer
        $allExtensions = DaftarMemoriTelepon::select('*', DB::raw("CAST(SUBSTRING(memori, 2) AS UNSIGNED) AS memori_number"))
            ->orderBy('memori_number', 'asc')
            ->get();

        $half = ceil($allExtensions->count() / 2);

        // Bagi data menjadi dua bagian setelah diurutkan
        $leftTableData = $allExtensions->take($half);
        $rightTableData = $allExtensions->slice($half);

        return view('PDF.export2', compact('leftTableData', 'rightTableData'));
    }
    public function exportpdf3()
    {
        $allExtensions = Dokter::all();
        $half = ceil($allExtensions->count() / 2);

        // Bagi data menjadi dua bagian
        $leftTableData = $allExtensions->take($half);
        $rightTableData = $allExtensions->slice($half);

        return view('PDF.export3', compact('leftTableData', 'rightTableData'));
    }
}
