<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends ResourceRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?User
    {
        return $this->model->find($id);
    }
}
