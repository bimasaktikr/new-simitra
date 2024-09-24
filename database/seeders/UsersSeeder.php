<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1, 
            'email' => 'admin@mitra.bpskotamalang.id', 
            'password' => bcrypt('@passwordadminmitra3573'),
            'role_id' => 1,
            'status' => 'Aktif'],

            ['id' => 2, 
            'email' => 'umars@bps.go.id', 
            'password' => bcrypt('kepalabps'),
            'role_id' => 2,
            'status' => 'Aktif'],

            ['id' => 3, 
            'email' => 'dwi@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 3,
            'status' => 'Aktif'],

            ['id' => 4, 
            'email' => 'wahyu@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 3,
            'status' => 'Aktif'],

            ['id' => 5, 
            'email' => 'tasmilah@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 3,
            'status' => 'Aktif'],

            ['id' => 6, 
            'email' => 'agustina@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 3,
            'status' => 'Aktif'],

            ['id' => 7, 
            'email' => 'junaedi@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 2,
            'status' => 'Aktif'],

            ['id' => 8, 
            'email' => 'anggi@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 9, 
            'email' => 'arini@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 1,
            'status' => 'Aktif'],
            
            ['id' => 10, 
            'email' => 'baqtiar@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 11, 
            'email' => 'bima@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 12, 
            'email' => 'eka@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 13, 
            'email' => 'erlisa@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 14, 
            'email' => 'ernawaty@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 3,
            'status' => 'Aktif'],
            
            ['id' => 15, 
            'email' => 'heru@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 16, 
            'email' => 'rachmad@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 17, 
            'email' => 'ratri@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 18, 
            'email' => 'rendra@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 19, 
            'email' => 'rhyke@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 20, 
            'email' => 'maulidya@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 21, 
            'email' => 'saras@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],

            ['id' => 22, 
            'email' => 'saruni@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 23, 
            'email' => 'satria@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 24, 
            'email' => 'siti@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
            ['id' => 25, 
            'email' => 'soekesi@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],

            ['id' => 26, 
            'email' => 'windi@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],

            ['id' => 27, 
            'email' => 'yenita@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],

            ['id' => 28, 
            'email' => 'yusuf@bps.go.id', 
            'password' => bcrypt('bpsmalang'),
            'role_id' => 4,
            'status' => 'Aktif'],
            
        ]);
    }
}