<?php

namespace App\Repositories;

use App\Models\Missions;

class MissionsRepository extends ResourceRepository
{
    public function __construct(Missions $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Missions
    {
        return $this->model->find($id);
    }
}
