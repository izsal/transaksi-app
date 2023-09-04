<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RekapTransaksiController extends Controller {
    public function __construct() {
    }

    public function index() {
        $category = Category::all();

        return view('backend.rekap_transaksi', compact('category'));
    }

    public function indexDataTable(Request $request) {
        $data = Transaksi::showRekapTransaksiDataTable(
            $request->get('startDate'),
            $request->get('endDate'),
            $request->get('categoryId'),
            $request->get('search'),
        );

        //\Log::info('data', $data);

        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal', '{{ $tanggal }}')
            ->addColumn('category', '{{ $category }}')
            ->addColumn('nominal', '{{$nominal}}')
            ->rawColumns([
                'tanggal',
                'category',
                'nominal',
            ]);

        return $dataTable->make(true);
    }
}
