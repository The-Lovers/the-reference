<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Continent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Modes possibles :
     * - 'UN'  => 195 pays ONU (cas A)
     * - 'ALL' => Pays + territoires avec flags (cas C)
     */
    private const MODE = 'ALL'; // <-- changer ici : 'UN' ou 'ALL'

    public function run()
    {
        $file = match (self::MODE) {
            'UN'  => 'countries_195_un.json',
            'ALL' => 'countries_all_with_flags.json',
            default => null,
        };

        if (! $file) {
            $this->command->error('Mode invalide');
            return;
        }

        $path = database_path("data/{$file}");

        if (! File::exists($path)) {
            $this->command->error("{$file} introuvable");
            return;
        }

        $countries = json_decode(File::get($path), true);

        foreach ($countries as $country) {

            // Sécurité minimale
            if (empty($country['code']) || empty($country['continent_en'])) {
                continue;
            }

            $continent = Continent::where(
                'label_en',
                $country['continent_en']
            )->first();

            if (! $continent) {
                continue;
            }

            Country::updateOrCreate(
                ['code' => $country['code']],
                [
                    'continent_id' => $continent->id,
                    'flag' => 'images/flags/'.strtoupper($country['code']) . '.svg',
                    'label_fr'     => $country['label_fr'],
                    'label_en'     => $country['label_en'],
                    'phone_code'   => $country['phone_code'] ?? null,
                    'devise_label' => $country['devise_label'] ?? null,
                    'devise_code'  => $country['devise_code'] ?? null,

                    // Flags (compatibles A & C)
                    'is_un_member' => $country['is_un_member'] ?? true,
                    'is_observer'  => $country['is_observer'] ?? false,
                    'is_territory' => $country['is_territory'] ?? false,
                ]
            );
        }

        $this->command->info('Countries seeded successfully (mode: ' . self::MODE . ')');
    }
}
