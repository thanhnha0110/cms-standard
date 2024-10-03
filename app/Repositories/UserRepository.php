<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserRepository extends BaseRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
    public function getUsersByRoles(Request $request);
    public function createUser($data);
    public function updateUser($user, $data);
    public function generateFor($userId);
    public function updateProfile($user, $data);
    public function getUsersByCreatedAt($start, $end);
    public function deleteUser($user);
    public function getWorkloads(Request $request);
    public function getProjects($userId);
    public function find($userId);
    public function getLeaveDatesByYear($user, $year = null);
    public function getLeaveDateInfoByYear($user, $year = null);
    public function updateLeaveDateInfo($data);
    public function getBonusDaysBySeniority($user, $year = null);
    public function getRemaining($user, $year = null);
    public function getWorkload(Request $request);
    public function updateNumberOfDays($user, array $data);
}
