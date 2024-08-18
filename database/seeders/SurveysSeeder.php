<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveysSeeder extends Seeder
{
    public function run()
    {
        DB::table('surveys')->insert([
            [
                'name' => 'Survei 1',
                'kode' => 'S001',
                'ketua_tim' => 'Tim A',
                'tanggal_mulai' => '2024-01-01',
                'tipe_pembayaran' => 'bulanan',
                'harga' => '1500000',
                'tanggal_berakhir' => '2024-01-31',
            ],
            [
                'name' => 'Survei 2',
                'kode' => 'S002',
                'ketua_tim' => 'Tim B',
                'tanggal_mulai' => '2024-02-01',
                'tipe_pembayaran' => 'per dokumen',
                'harga' => '50000',
                'tanggal_berakhir' => '2024-02-28',
            ],
        ]);
    }
}
