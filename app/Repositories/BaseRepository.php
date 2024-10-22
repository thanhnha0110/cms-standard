<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface CoreRepository
 * @package Modules\Core\Repositories
 */
interface BaseRepository
{
    /**
     * @param  int $id
     * @return $model
     */
    public function find($id);

    /**
     * @param  int $id
     */
    public function findOrFail($id);

    /**
     * @param array $condition
     */
    public function findMany($condition);

    /**
     * Return a collection of all elements of the resource
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * @return Builder
     */
    public function allWithBuilder() : Builder;

    /**
     * Paginate the model to $perPage items per page
     * @param  int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15);

    /**
     * Create a resource
     * @param  $data
     * @return $model
     */
    public function create($data);

    /**
     * Update a resource
     * @param  $model
     * @param  array $data
     * @return $model
     */
    public function update($model, $data);

    /**
     * Destroy a resource
     * @param  $model
     * @return bool
     */
    public function destroy($model);

    /**
     * Destroy many resource by condition
     * @param  $model
     * @return bool
     */
    public function delete($condition);

    /**
     * Return resources translated in the given language
     * @param  string $lang
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allTranslatedIn($lang);

    /**
     * Find a resource by the given slug
     * @param  string $slug
     * @return $model
     */
    public function findBySlug($slug);

    /**
     * Find a resource by an array of attributes
     * @param  array $attributes
     * @return object
     */
    public function findByAttributes(array $attributes);

    /**
     * Find a latest resource by an array of attributes
     * @param  array $attributes
     * @return $model
     */
    public function findLatestByAttributes(array $attributes);

    /**
     * Return a collection of elements who's ids match
     * @param  array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByMany(array $ids);

    /**
     * Get resources by an array of attributes
     * @param  array $attributes
     * @param  null|string $orderBy
     * @param  string $sortOrder
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc');

    /**
     * Clear the cache for this Repositories' Entity
     * @return bool
     */
    public function clearCache();

    /**
     * Update or create
     * @param array $conditions
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate($conditions = [], $attributes = []);

    /**
     * Return column id as array
     * @param string $columnName
     * @return mixed
     */
    public function pluck($columnName);
}