<?php

namespace App\Repositories\Impl;

use App\Repositories\ActivityLogRepository;
use App\Models\ActivityLog;

class ActivityLogRepositoryImpl implements ActivityLogRepository
{
    public function create(array $data)
    {
        return ActivityLog::create($data);
    }

    public function recent(int $limit = 5)
    {
        return ActivityLog::with('user')->latest()->take($limit)->get();
    }

    public function paginate(int $perPage = 20, ?int $userId = null, ?string $subjectType = null)
    {
        return ActivityLog::with('user')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($subjectType, fn($q) => $q->where('subject_type', $subjectType))
            ->latest()
            ->paginate($perPage);
    }
}
