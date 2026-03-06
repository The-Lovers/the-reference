<?php

namespace App\Repositories;

use App\Models\Services;

class ServicesRepository extends ResourceRepository
{
    public function __construct(Services $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Services
    {
        return $this->model->find($id);
    }
}
