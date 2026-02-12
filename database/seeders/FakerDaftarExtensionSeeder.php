<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DaftarExtension;
use Faker\Factory as Faker;

class FakerDaftarExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 100; $i++) {
            DaftarExtension::create([
                'ext' => $faker->numerify('###'),
                'nama' => $faker->name
            ]);
        }
    }
}
