<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends ResourceRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Role
    {
        return $this->model->find($id);
    }
}