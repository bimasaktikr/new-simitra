<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariabelPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variabel_penilaians')->insert([
            [
                'variabel' => 'Kualitas Data',
                'tahap' => 1,
            ],
            [
                'variabel' => 'Ketepatan Waktu',
                'tahap' => 1,
            ],
            [
                'variabel' => 'Pemahaman Pengetahuan Kerja',
                'tahap' => 1,
            ],
            [
                'variabel' => 'Adaptif',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Akuntabel',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Amanah',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Disiplin',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Harmonis',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Inovatif',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Kolaboratif',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Kompeten',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Loyal',
                'tahap' => 2,
            ],
            [
                'variabel' => 'Pelayanan',
                'tahap' => 2,
            ]
        ]);
    }
}
