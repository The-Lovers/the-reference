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

    public function search(?string $term = null)
    {
        return $this->getAllWithSearch(
            $term,
            ['title', 'description', 'icon'],
            ['creator', 'updater', 'statusUpdatedBy', 'featuredUpdatedBy'],
            fn ($query) => $query->orderByDesc('is_featured')->orderBy('title')
        );
    }

    public function getById(int $id): ?Missions
    {
        return $this->model->find($id);
    }

    public function getAllWithOrder()
    {
        return $this->model
            ->with(['creator', 'updater', 'statusUpdatedBy', 'featuredUpdatedBy'])
            ->where('status', 1)
            ->orderByDesc('is_featured')
            // ->orderByDesc('created_at')
            // ->orderByDesc('updated_at')
            ->get();
    }
}
