<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use DB;
use Flash;
use Illuminate\Http\Request;
use Log;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller {

    public function __construct() {
    }

    public function index() {
        $category = Category::all();

        return view('backend.transaksi', compact('category'));
    }

    public function indexDataTable(Request $request) {
        $data = Transaksi::showTransaksiDataTable(
            $request->get('startDate'),
            $request->get('endDate'),
            $request->get('categoryId'),
            $request->get('search'),
        );

        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('description', '{{ $description }}')
            ->addColumn('code', '{{ $code }}')
            ->addColumn('rate_euro', '{{$rate_euro}}')
            ->addColumn('date_paid', '{{$date_paid}}')
            ->addColumn('action', function ($data) {
                $data = $data->id;
                return view('backend.includes.action_transaksi', compact('data'));
            })
            ->rawColumns([
                'description',
                'code',
                'rate_euro',
                'date_paid',
                'action'
            ]);

        $dataTable = $dataTable->make(true);
        return $dataTable;
    }

    public function create() {
        $category = Category::all();
        $mode = 'Input';
        $saveRoute = 'backend.save_transaksi';
        $data = [];

        return view('backend.add_transaksi', compact(
            'category',
            'mode',
            'saveRoute',
            'data'
        ));
    }

    public function edit(Request $request, $id) {
        $category = Category::all();
        $mode = 'Edit';
        $saveRoute = 'backend.update_transaksi';

        $transaksi = Transaksi::showDetailTransaksiById($id);
        if (empty($transaksi)) {
            Flash::error('Transaksi Tidak Valid');
            return redirect()->back();
        }

        $transaksiDetail = TransaksiDetail::byTransaksiId($id);

        $data = [
            'description' => $transaksi->description,
            'code' => $transaksi->code,
            'rate_euro' => $transaksi->rate_euro,
            'date_paid' => $transaksi->date_paid,
            'detail' => $transaksiDetail
        ];

        return view('backend.add_transaksi', compact(
            'category',
            'mode',
            'saveRoute',
            'data'
        ));
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {

            Transaksi::query()->insert([
                'description' => $request->description,
                'code' => $request->code,
                'rate_euro' => $request->rate_euro,
                'date_paid' => $request->date_paid,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $transaksiId = DB::getPdo()->lastInsertId();
            $transaksiDetail = json_decode($request->transaksi_detail);
            if (count($transaksiDetail) > 0) {
                foreach ($transaksiDetail as $detail) {
                    if (count($detail->items) > 0) {
                        foreach ($detail->items as $item) {
                            TransaksiDetail::query()->insert([
                                'transaksi_id' => $transaksiId,
                                'category_id' => $detail->category,
                                'nama_transaksi' => $item->nama,
                                'nominal' => $item->nominal,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            Flash::success('Berhasil Menambahkan Data');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('error store transaksi >>> ' . $e);
            Flash::error('Gagal Menambahkan Data, Error');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->description = $request->description;
            $transaksi->code = $request->code;
            $transaksi->rate_euro = $request->rate_euro;
            $transaksi->date_paid = $request->date_paid;
            $transaksi->updated_at = Carbon::now();
            $transaksi->save();

            $transaksiDetail = json_decode($request->transaksi_detail);
            if (count($transaksiDetail) > 0) {
                foreach ($transaksiDetail as $detail) {
                    if (count($detail->items) > 0) {
                        foreach ($detail->items as $item) {
                            if (isset($item->id) && !empty($item->id)) {
                                TransaksiDetail::query()
                                    ->where('id', $item->id)
                                    ->update([
                                        'category_id' => $detail->category,
                                        'nama_transaksi' => $item->nama,
                                        'nominal' => $item->nominal,
                                        'updated_at' => Carbon::now(),
                                    ]);
                            } else {
                                TransaksiDetail::query()->insert([
                                    'transaksi_id' => $id,
                                    'category_id' => $detail->category,
                                    'nama_transaksi' => $item->nama,
                                    'nominal' => $item->nominal,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }
                    }
                }
            }
            DB::commit();

            Flash::success('Berhasil Update Data');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('error update transaksi >>> ' . $e);
            Flash::success('Gagal Update Data, Error');
        }

        return redirect()->back();
    }

    public function destroy(Request $request, $id) {
        DB::beginTransaction();
        try {
            $transaksi = TransaksiDetail::findOrFail($id);
            $transaksi->delete();
            DB::commit();

            Flash::success('Berhasil Hapus Data');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('error hapus transaksi >>> ' . $e);
            Flash::success('Gagal Hapus Data, Error');
        }

        return redirect()->back();
    }
}
