<?php

namespace App\Repositories;

interface ActivityLogRepository
{
    public function create(array $data);
    public function recent(int $limit = 5);
    public function paginate(int $perPage = 20, ?int $userId = null, ?string $subjectType = null);
}
