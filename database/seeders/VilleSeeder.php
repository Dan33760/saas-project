<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('villes')->insert([
            [
                'pays_id' => 52,
                'nom_ville' => 'Goma'
            ],
            [
                'pays_id' => 52,
                'nom_ville' => 'Butembo'
            ],
            [
                'pays_id' => 52,
                'nom_ville' => 'Kinshasa'
            ],
            [
                'pays_id' => 52,
                'nom_ville' => 'Lubumbashi'
            ],
            [
                'pays_id' => 52,
                'nom_ville' => 'Beni'
            ],
            [
                'pays_id' => 52,
                'nom_ville' => 'Kisangani'
            ],
            [
                'pays_id' => 33,
                'nom_ville' => 'Bujumbura'
            ],
            [
                'pays_id' => 33,
                'nom_ville' => 'Gitega'
            ],
        ]);
    }
}
