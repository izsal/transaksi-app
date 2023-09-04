<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model {
    use HasFactory;

    protected $table = 'transaksi_detail';

    protected $fillable = [
        'transaksi_id',
        'category_id',
        'nama_transaksi',
        'nominal',
        'created_at',
        'updated_at'
    ];

    public static function byTransaksiId($transaksiId) {
        $transaksi = self::query()
            ->join('category as c1', 'c1.id', '=', 'transaksi_detail.category_id')
            ->select('transaksi_detail.*', 'c1.name as category')
            ->where('transaksi_detail.transaksi_id', $transaksiId)
            ->get();

        return $transaksi;
    }
}
