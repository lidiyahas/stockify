<?php

namespace App\Services\Impl;

use App\Services\ActivityLogService;
use App\Repositories\ActivityLogRepository;
use Illuminate\Support\Facades\Auth;

class ActivityLogServiceImpl implements ActivityLogService
{
    private ActivityLogRepository $repo;

    public function __construct(ActivityLogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function log(string $action, string $description, ?string $subjectType = null, ?int $subjectId = null, ?int $userId = null): void
    {
        $this->repo->create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
        ]);
    }

    public function getRecent(int $limit = 5)
    {
        return $this->repo->recent($limit);
    }

    public function getPaginated(int $perPage = 20, ?int $userId = null, ?string $subjectType = null)
    {
        return $this->repo->paginate($perPage, $userId, $subjectType);
    }
}
