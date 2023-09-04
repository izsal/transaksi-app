<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Arr;
use DB;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;

class TransaksiSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //$generator = new Generator();
        $transaksi = [
            [
                'date_paid' => date('Y-m-d', strtotime('2023-01-02')),
                'rate_euro' => 10000,
                'code' => 112233,
                'description' => 'TEST DESC 1',
                'created_at' => date('Y-m-d', strtotime('2023-01-01')),
                'updated_at' => date('Y-m-d', strtotime('2023-01-01')),
            ],
            [
                'date_paid' => date('Y-m-d', strtotime('2023-02-02')),
                'rate_euro' => 20000,
                'code' => 445566,
                'description' => 'TEST DESC 2',
                'created_at' => date('Y-m-d', strtotime('2023-02-02')),
                'updated_at' => date('Y-m-d', strtotime('2023-02-02')),
            ]
        ];


        $count = 1;
        foreach ($transaksi as $t) {
            $count++;
            $id = Transaksi::create($t)->id;

            $transaksiDetail = [
                [
                    'transaksi_id' => $id,
                    'category_id' => Arr::random([1, 2]),
                    'nama_transaksi' => 'test ' . $count,
                    'nominal' => 1000 * $count,
                    'created_at' => date('Y-m-d', strtotime('2023-02-02')),
                    'updated_at' => date('Y-m-d', strtotime('2023-02-02')),
                ],
                [
                    'transaksi_id' => $id,
                    'category_id' => Arr::random([1, 2]),
                    'nama_transaksi' => 'test ' . $count,
                    'nominal' => 1000 * $count,
                    'created_at' => date('Y-m-d', strtotime('2023-02-02')),
                    'updated_at' => date('Y-m-d', strtotime('2023-02-02')),
                ]
            ];

            foreach ($transaksiDetail as $t2) {
                TransaksiDetail::create($t2);
            }
        }
    }
}
