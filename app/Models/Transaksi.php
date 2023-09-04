<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'date_paid',
        'rate_euro',
        'code',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function showDetailTransaksiById($transaksiDetailId) {
        return self::showTransaksiDataTable(
            '',
            '',
            '',
            '',
            $transaksiDetailId
        );
    }

    public static function showTransaksiDataTable(
        $startDate = '',
        $endDate = '',
        $categoryId = '',
        $search = '',
        $id = ''
    ) {
        $transaksi = self::query()
            ->selectRaw('
                    transaksi.id,
                    transaksi.description,
                    transaksi.`code`,
                    transaksi.rate_euro,
                    transaksi.date_paid
            ')
            ->orderBy('transaksi.date_paid');

        if (!empty($startDate) && !empty($endDate)) {
            $transaksi->whereRaw("date(transaksi.created_at) between '$startDate' and '$endDate'");
        }
        if (!empty($categoryId)) {
            $transaksi->where('c1.id', $categoryId);
        }
        if (!empty($search)) {
            $transaksi->whereRaw("transaksi.description like '%$search%'");
        }

        if (!empty($id)) {
            $transaksi->where('id', $id);
            return $transaksi->first();
        }

        return $transaksi->get();
    }

    public static function showRekapTransaksiDataTable(
        $startDate,
        $endDate,
        $categoryId,
        $search
    ) {
        $transaksi = self::query()
            ->join('transaksi_detail as t2', 'transaksi.id', '=', 't2.transaksi_id')
            ->join('category as c1', 't2.category_id', '=', 'c1.id')
            ->selectRaw('
                    t2.transaksi_id,
                    t2.category_id,
                    c1.`name` as category,
                    sum(t2.nominal) as nominal,
                    date(transaksi.created_at) as tanggal
            ')
            ->orderBy('transaksi.date_paid')
            ->groupByRaw('transaksi.id, c1.id');

        if (!empty($startDate) && !empty($endDate)) {
            $transaksi->whereRaw("transaksi.created_at between '$startDate' and '$endDate'");
        }
        if (!empty($categoryId)) {
            $transaksi->where('c1.id', $categoryId);
        }
        if (!empty($search)) {
            $transaksi->whereRaw("t2.nama_transaksi like '%$search%'");
        }

        return $transaksi->get();
    }
}
