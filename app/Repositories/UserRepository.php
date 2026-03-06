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
    public function getAllWithSearch(?string $term = null, array $fields = [], int $perPage = 15) {
        $query = $this->model->query();

        if (!empty($term) && !empty($fields)) {
            $query->where(function ($q) use ($term, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$term}%");
                }
            });
        }

        return $query->paginate($perPage);
    }
}
