<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $startTime = Carbon::createFromTime(6, 0, 0); // Waktu mulai pukul 6 pagi
        $endTime = Carbon::createFromTime(18, 0, 0); // Waktu selesai pukul 6 sore

        foreach (range(1, 10) as $index) {
            $status = $faker->randomElements(['izin', 'sakit'])[0];
            if($status == 'sakit') {
                $tipe = 'hari';
            }else{
                $tipe = $faker->randomElements(['jam', 'hari'])[0];
            }
            $randomDate = $faker->dateTimeBetween('tomorrow', '+7 days');
            $tanggal_mulai = $randomDate->format('Y-m-d');
            $jumlah_jam = 0;
            if($tipe == 'jam' && $status == 'izin') {
                $tanggal_selesai = $tanggal_mulai;
                $randomStartTime  = $faker->dateTimeBetween($startTime, $endTime);
                $endTimeRange  = Carbon::parse($randomStartTime )->addHours($faker->numberBetween(1, 3));
                $jam_mulai = $randomStartTime->format('H:i:s');
                $jam_selesai = $endTimeRange->format('H:i:s');
                $jumlah_jam = Carbon::instance($randomStartTime)->diffInHours($endTimeRange);
            }else{
                $randomDays = $faker->numberBetween(0, 1);
                $newDate = Carbon::instance($randomDate)->addDays($randomDays);
                $tanggal_selesai = $newDate->format('Y-m-d');
                $jam_mulai = null;
                $jam_selesai = null;
                $jumlah_jam = (Carbon::instance($randomDate)->diffInDays($newDate) + 1) * 8;
            }
            $approved = $faker->randomElements(['disetujui', 'ditolak', 'butuh persetujuan'])[0];
            DB::table('absences')->insert([
                'user_id' =>$faker->numberBetween(2, 26),
                'status' => $status,
                'tipe' => $tipe,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'jumlah_jam' => $jumlah_jam,
                'alasan' => $status,
                'approved' => $approved,
                'approved_by' => $approved == 'butuh persetujuan' ? null : 1,
                'pemotongan' => $status == 'izin' ? 1 : 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
