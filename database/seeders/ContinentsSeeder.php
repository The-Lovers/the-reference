<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continents = [
            ['label_fr' => 'Afrique',  'label_en' => 'Africa'],
            ['label_fr' => 'Europe',   'label_en' => 'Europe'],
            ['label_fr' => 'Asie',     'label_en' => 'Asia'],
            ['label_fr' => 'Amérique', 'label_en' => 'America'],
            ['label_fr' => 'Océanie',  'label_en' => 'Oceania'],
        ];

        foreach ($continents as $continent) {
            Continent::firstOrCreate(
                ['label_en' => $continent['label_en']],
                $continent
            );
        }
    }
}
