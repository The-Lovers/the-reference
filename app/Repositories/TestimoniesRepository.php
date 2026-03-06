<?php

namespace App\Repositories;

use App\Models\Testimonies;

class TestimoniesRepository extends ResourceRepository
{
    public function __construct(Testimonies $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Testimonies
    {
        return $this->model->find($id);
    }
}
