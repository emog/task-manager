<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskFormRequest;
use App\Http\Requests\GetTaskFormRequest;
use App\Http\Requests\UpdateTaskFormRequest;
use App\Http\Resources\TaskDetailsResource;
use App\Services\TaskService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getAll()
    {
        return $this->taskService->getAll();

    }

    public function create(CreateTaskFormRequest $request)
    {
        return $this->taskService->create(auth()->id(), $request->only(['name', 'description', 'completed']));

    }

    public function update(UpdateTaskFormRequest $request)
    {
        $this->taskService->update($request->route('id'), $request->only(['name', 'description', 'completed']));
    }

    public function show(GetTaskFormRequest $request)
    {
        return $this->taskService->getById($request->route('id'));
    }
}
