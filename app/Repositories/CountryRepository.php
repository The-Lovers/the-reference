<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository extends ResourceRepository
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Country
    {
        return $this->model->find($id);
    }
}