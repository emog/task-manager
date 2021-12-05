<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskFormRequest;
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
        $tasks = $this->taskService->getAll();
        return (new TaskDetailsResource($tasks))->response()->setStatusCode(200);

    }

    public function create(CreateTaskFormRequest $request)
    {
        $task = $this->taskService->create(auth()->id(), $request->only(['name', 'description', 'completed']));
        return (new TaskDetailsResource($task))->response()->setStatusCode(201);
    }

    public function update(UpdateTaskFormRequest $request)
    {
        $this->taskService->update($request->route('id'), $request->only(['name', 'description', 'completed']));
    }
}
