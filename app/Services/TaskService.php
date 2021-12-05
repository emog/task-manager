<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAll()
    {
        return $this->taskRepository->getAll();
    }

    public function create($user_id, $data)
    {
        $data['user_id'] = $user_id;
        return $this->taskRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->taskRepository->update($id, $data);
    }
}
