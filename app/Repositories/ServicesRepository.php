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

    public function search(?string $term = null)
    {
        return $this->getAllWithSearch(
            $term,
            ['title', 'description'],
            [],
            fn ($query) => $query->orderByDesc('is_featured')->orderBy('title')
        );
    }

    public function getById(int $id): ?Services
    {
        return $this->model->find($id);
    }

    public function getAllWithOrder()
    {
        return $this->model
            ->where('is_active', 1)
            ->orderByDesc('is_featured')
            ->orderBy('title')
            ->get();
    }
}
