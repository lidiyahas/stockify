<?php

namespace App\Services;

interface ActivityLogService
{
    public function log(string $action, string $description, ?string $subjectType = null, ?int $subjectId = null, ?int $userId = null): void;
    public function getRecent(int $limit = 5);
    public function getPaginated(int $perPage = 20, ?int $userId = null, ?string $subjectType = null);
}
