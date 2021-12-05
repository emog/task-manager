<?php

namespace App\Services;

use App\Http\Resources\TaskDetailsResource;
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
        $tasks = $this->taskRepository->getAll();
        return (new TaskDetailsResource($tasks))->response()->setStatusCode(200);
    }

    public function create($user_id, $data)
    {
        $data['user_id'] = $user_id;
        $task            = $this->taskRepository->create($data);
        return (new TaskDetailsResource($task))->response()->setStatusCode(201);
    }

    public function update(int $id, array $data)
    {
        return $this->taskRepository->update($id, $data);
    }

    public function getById(int $id)
    {
        $task = $this->taskRepository->getById($id);
        return (new TaskDetailsResource($task))->response()->setStatusCode(200);
    }
}
