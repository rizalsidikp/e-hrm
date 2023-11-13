<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        foreach (range(1, 10) as $index) {
            $user_id = $faker->numberBetween(2, 26);
            DB::table('bonuses')->insert([
                'user_id' => $user_id,
                'bonus' => $faker->randomElement([100000,200000,300000,400000,500000,600000,700000,800000,900000,1000000]),
                'periode' => '2023-'.$faker->randomNumber(1,12).'-15',
                'deskripsi' => 'Bonus',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
