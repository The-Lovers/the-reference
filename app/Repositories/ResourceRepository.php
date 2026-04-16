<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

abstract class ResourceRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(string $attribute, mixed $value, bool $first = true): mixed
    {
        $query = $this->model->where($attribute, $value);

        return $first ? $query->first() : $query->get();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getAllWithSearch(
        ?string $term = null,
        array $fields = [],
        array $with = [],
        ?callable $queryCallback = null,
    ): Collection {
        $query = $this->model->newQuery()->with($with);

        $this->applySearch($query, $term, $fields);

        if ($queryCallback) {
            $queryCallback($query);
        }

        return $query->get();
    }

    protected function applySearch(Builder $query, ?string $term, array $fields): void
    {
        $term = trim((string) $term);

        if ($term === '' || empty($fields)) {
            return;
        }

        $query->where(function (Builder $builder) use ($fields, $term) {
            foreach ($fields as $field) {
                if (is_string($field)) {
                    $builder->orWhere($field, 'LIKE', "%{$term}%");
                    continue;
                }

                if (!is_array($field)) {
                    continue;
                }

                foreach ($field as $relation => $relationFields) {
                    $relationFields = (array) $relationFields;

                    $builder->orWhereHas($relation, function (Builder $relationQuery) use ($relationFields, $term) {
                        foreach ($relationFields as $relationField) {
                            $relationQuery->orWhere($relationField, 'LIKE', "%{$term}%");
                        }
                    });
                }
            }
        });
    }
}
