<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        foreach (range(1, 10) as $index) {
            $tipe_pelatihan = $faker->randomElement(['pegawai','pegawai','pegawai', 'perusahaan']);
            $pelatihan_pegawai = ['Pelatihan Keselamatan Kerja di SPBU', 'Pelatihan Penanganan Bahan Bakar', 'Pelatihan Pemadam Kebakaran', 'Pelatihan Evakuasi Darurat', 'Pelatihan Penanganan Situasi Krisis'];
            $pelatihan_perusahaan = ['Sertifikat Kelayakan Operasional', 'Sertifikat Kepatuhan Lingkungan', 'Sertifikat Kepatuhan Keselamatan Kerja'];
            $user_id = null;
            $nama = '';
            if($tipe_pelatihan == 'pegawai'){
                $user_id = $faker->numberBetween(2, 26);
                $nama = $faker->randomElement($pelatihan_pegawai);
            }else{
                $nama = $faker->randomElement($pelatihan_perusahaan);
            }
            DB::table('trainings')->insert([
                'user_id' => $user_id,
                'tipe_pelatihan' => $tipe_pelatihan,
                'nama' => $nama,
                'deskripsi' => $nama,
                'file' => 'images/pelatihan/1698341247_conference-template-a4.docx',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
