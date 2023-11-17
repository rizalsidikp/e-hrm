<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 4,
                'label' => 'Lembur Pegawai',
                'icon' => 'fa-business-time',
                'url' => 'overtime-management',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'label' => 'Bonus Pegawai',
                'icon' => 'fa-money-bill',
                'url' => 'bonus-management',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'label' => 'Pelatihan Pegawai',
                'icon' => 'fa-laptop',
                'url' => 'training-management',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('favorites')->insert($data);
    }
}
