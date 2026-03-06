<?php

namespace App\Repositories;

use App\Models\Domains;

class DomainsRepository extends ResourceRepository
{
    public function __construct(Domains $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Domains
    {
        return $this->model->find($id);
    }
}
