<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;

/**
 * Class EloquentCoreRepository
 *
 * @package Modules\Core\Repositories\Eloquent
 */
abstract class EloquentBaseRepository implements BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model An instance of the Eloquent Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->find($id);
        }

        return $this->model->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findOrFail($id)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->find($id);
        }

        return $this->model->findOrFail($id);
    }

    /**
     * @inheritdoc
     */
    public function findMany($condition)
    {
        return $this->model->where($condition)->get();
    }

    /**
     * @inheritdoc
     */
    public function all()
    {
        $created_at = $this->model::CREATED_AT ? $this->model::CREATED_AT : 'created_at';
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->orderBy($created_at, 'DESC')->get();
        }

        return $this->model->orderBy($created_at, 'DESC')->get();
    }

    /**
     * @inheritdoc
     */
    public function allWithBuilder() : Builder
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations');
        }

        return $this->model->query();
    }

    /**
     * @inheritdoc
     */
    public function paginate($perPage = 15)
    {
        $created_at = $this->model::CREATED_AT ? $this->model::CREATED_AT : 'created_at';
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->orderBy($created_at, 'DESC')->paginate($perPage);
        }

        return $this->model->orderBy($created_at, 'DESC')->paginate($perPage);
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update($model, $data)
    {
        $model->update($data);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function destroy($model)
    {
        return $model->delete();
    }

    /**
     * @inheritdoc
     */
    public function delete($condition)
    {
        return $this->model->where($condition)->delete();
    }

    /**
     * @inheritdoc
     */
    public function allTranslatedIn($lang)
    {
        $created_at = $this->model::CREATED_AT ? $this->model::CREATED_AT : 'created_at';
        return $this->model->whereHas('translations', function (Builder $q) use ($lang) {
            $q->where('locale', "$lang");
        })->with('translations')->orderBy($created_at, 'DESC')->get();
    }

    /**
     * @inheritdoc
     */
    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with('translations')->first();
        }

        return $this->model->where('slug', $slug)->first();
    }

    /**
     * @inheritdoc
     */
    public function findByAttributes(array $attributes)
    {
        $query = $this->buildQueryByAttributes($attributes);

        return $query->first();
    }

    /**
     * @inheritdoc
     */
    public function findLatestByAttributes(array $attributes)
    {
        $query = $this->buildQueryByAttributes($attributes);

        return $query->latest()->first();
    }

    /**
     * @inheritdoc
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->buildQueryByAttributes($attributes, $orderBy, $sortOrder);

        return $query->get();
    }

    /**
     * Build Query to catch resources by an array of attributes and params
     * @param  array $attributes
     * @param  null|string $orderBy
     * @param  string $sortOrder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function buildQueryByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->model->query();

        if (method_exists($this->model, 'translations')) {
            $query = $query->with('translations');
        }

        foreach ($attributes as $field => $value) {
            $query = $query->where($field, $value);
        }

        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function findByMany(array $ids)
    {
        $query = $this->model->query();

        if (method_exists($this->model, 'translations')) {
            $query = $query->with('translations');
        }

        return $query->whereIn("id", $ids)->get();
    }

    /**
     * @inheritdoc
     */
    public function clearCache()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function updateOrCreate($conditions = [], $attributes = [])
    {
        return $this->model->updateOrCreate($conditions, $attributes);
    }

    /**
     * @inheritdoc
     */
    public function pluck($columnName) {
        return $this->model->pluck($columnName)->toArray();
    }
}