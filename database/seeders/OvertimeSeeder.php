<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class OvertimeSeeder extends Seeder
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
            $user_id = $faker->numberBetween(2, 26);
            while ($user_id == 13 || $user_id == 6) {
                $user_id = $faker->numberBetween(1, 26);
            }
            $randomDate = $faker->dateTimeBetween('tomorrow', '+7 days');
            $tanggal = $randomDate->format('Y-m-d');
            $randomStartTime  = $faker->dateTimeBetween($startTime, $endTime);
            $endTimeRange  = Carbon::parse($randomStartTime )->addHours($faker->numberBetween(1, 3));
            $jam_mulai = $randomStartTime->format('H:i:s');
            $jam_selesai = $endTimeRange->format('H:i:s');
            $jumlah_jam = Carbon::instance($randomStartTime)->diffInHours($endTimeRange);
            DB::table('overtimes')->insert([
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'shift' => $faker->randomElements(['pagi', 'siang'])[0],
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'jumlah_jam' => $jumlah_jam,
                'approved_user' => $faker->randomElements(['disetujui', 'disetujui', 'disetujui', 'disetujui', 'butuh persetujuan'])[0],
                'approved_pengawas' => $faker->randomElements(['disetujui', 'disetujui','disetujui', 'disetujui','disetujui', 'disetujui','disetujui', 'disetujui', 'ditolak', 'butuh persetujuan'])[0],
                'approved_manajer' => $faker->randomElements(['disetujui', 'disetujui','disetujui', 'disetujui','disetujui', 'disetujui','disetujui', 'disetujui', 'ditolak', 'butuh persetujuan'])[0],
                'pengawas_id' => 13,
                'manajer_id' => 6,
                'jumlah_operator' => $faker->numberBetween(1, 5),
                'alasan' => 'Kekurangan orang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
