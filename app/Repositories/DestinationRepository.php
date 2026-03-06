<?php

namespace App\Repositories;

use App\Models\Destination;

class DestinationRepository extends ResourceRepository
{
    public function __construct(Destination $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Destination
    {
        return $this->model->find($id);
    }
}
