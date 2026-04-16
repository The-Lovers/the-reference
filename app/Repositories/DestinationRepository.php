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

    public function search(?string $term = null)
    {
        return $this->getAllWithSearch(
            $term,
            [
                'label',
                'description',
                'price',
                ['pays' => ['label_fr', 'label_en']],
            ],
            ['pays'],
            fn ($query) => $query->orderBy('label')
        );
    }

    public function getById(int $id): ?Destination
    {
        return $this->model->find($id);
    }

    public function getAllWithOrder()
    {
        return $this->model
            ->with('pays')
            ->where('is_available', 1)
            ->orderBy('label')
            ->get();
    }
}
