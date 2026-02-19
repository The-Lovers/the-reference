<?php

namespace App\Repositories;

use App\Models\Country;

class PhoneCodeRepository
{
    /**
     * Retourne une collection d'objets pays contenant `phone_code`.
     *
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAll()
    {
        // Tente de récupérer depuis la table countries
        if (class_exists(Country::class)) {
            return Country::select(['label_fr', 'label_en', 'code', 'phone_code', 'flag'])->whereNotNull('phone_code')->orderBy('label_fr')->get();
        }

        return [];
    }
}
