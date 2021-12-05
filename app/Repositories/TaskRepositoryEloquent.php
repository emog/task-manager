<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepositoryEloquent implements TaskRepositoryInterface
{

    public function getAll()
    {
        return Task::orderBy('created_at', 'desc')->orderBy('completed', 'desc')->get();
    }

    public function getById(int $id)
    {
        return Task::findOrFail($id);
    }

    /**
     * @param array $data
     * @return Task|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Task::findOrFail($id)->update($data);
    }

    public function delete(int $id): ?bool
    {
        return Task::findOrFail($id)->delete();
    }
}
