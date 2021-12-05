<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithFaker;
    use LazilyRefreshDatabase;

    const REQUEST_HEADERS = ['Accept' => 'application/json'];

    public function test_get_all_tasks()
    {
        $user = $this->signIn();
        Task::factory(['user_id' => $user])->count(10)->create();
        $response = $this->get('/api/v1/task', self::REQUEST_HEADERS);
        $response->assertOk();
        $response->assertJsonCount(10, 'data');
    }

    public function test_cannot_get_tasks_for_other_users()
    {
        $user = $this->signIn();
        Task::factory()->count(10)->create();
        Task::factory(['user_id' => $user])->count(1)->create();
        $response = $this->get('/api/v1/task', self::REQUEST_HEADERS);
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

    public function test_guest_cannot_get_tasks()
    {
        $response = $this->get('/api/v1/task', self::REQUEST_HEADERS);
        $response->assertStatus(401);
    }

    public function test_create_task()
    {
        $this->signIn();
        $name        = $this->faker->text(100);
        $description = $this->faker->text(255);
        $response    = $this->post('/api/v1/task', ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertCreated();
        $response->assertJsonStructure(['data' => ['id', 'name', 'description', 'name', 'updated_at', 'created_at']]);
    }

    public function test_guest_cannot_create_task()
    {
        $name        = $this->faker->text(100);
        $description = $this->faker->text(255);
        $response    = $this->post('/api/v1/task', ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertStatus(401);
    }

    public function test_create_task_invalid_inputs()
    {
        $this->signIn();
        $name        = $this->faker->unique->realTextBetween(256, 300);
        $description = $this->faker->unique->realTextBetween(256, 300);
        $response    = $this->post('/api/v1/task', ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'description']);

        $response = $this->post('/api/v1/task', [], self::REQUEST_HEADERS);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_update_task()
    {
        $user        = $this->signIn();
        $task        = Task::factory(['user_id' => $user->id])->create();
        $name        = $this->faker->unique->text(100);
        $description = $this->faker->unique->text(255);
        $response    = $this->put('/api/v1/task/' . $task->id, ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertOk();
    }

    public function test_guest_cannot_update_task()
    {
        $task        = Task::factory()->create();
        $name        = $this->faker->text(100);
        $description = $this->faker->text(255);
        $response    = $this->put('/api/v1/task/' . $task->id, ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertStatus(401);
    }

    public function test_update_task_invalid_inputs()
    {
        $user        = $this->signIn();
        $task        = Task::factory(['user_id' => $user->id])->create();
        $name        = $this->faker->unique->realTextBetween(256, 300);
        $description = $this->faker->unique->realTextBetween(256, 300);
        $invalidId   = ($task->id + 10);
        $response    = $this->put('/api/v1/task/' . $invalidId, ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'id'          => 'The selected id is invalid.',
            'name'        => 'The name must not be greater than 255 characters.',
            'description' => 'The description must not be greater than 255 characters.'
        ]);

        $response = $this->put('/api/v1/task/' . $invalidId, [], self::REQUEST_HEADERS);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id' => 'The selected id is invalid.', 'name' => 'The name field is required.']);
    }

    public function test_user_cannot_update_task_for_other_user()
    {
        $this->signIn();
        $task        = Task::factory(['user_id' => User::factory()])->create();
        $name        = $this->faker->unique->text(100);
        $description = $this->faker->unique->text(100);
        $response    = $this->put('/api/v1/task/' . $task->id, ['name' => $name, 'description' => $description], self::REQUEST_HEADERS);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id' => 'The selected id is invalid.']);
    }

    public function test_get_user_task()
    {
        $user     = $this->signIn();
        $task     = Task::factory(['user_id' => $user->id])->create();
        $response = $this->get('/api/v1/task/' . $task->id, self::REQUEST_HEADERS);

        $response->assertOk();
        $response->assertJsonStructure(['data' => ['id', 'name', 'description', 'name', 'updated_at', 'created_at']]);
    }

    public function test_user_cannot_get_other_user_task()
    {
        $this->signIn();
        $task     = Task::factory()->create();
        $response = $this->get('/api/v1/task/' . $task->id, self::REQUEST_HEADERS);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id' => 'The selected id is invalid.']);
    }

    public function test_guest_cannot_get_task()
    {
        $task     = Task::factory()->create();
        $response = $this->get('/api/v1/task/' . $task->id, self::REQUEST_HEADERS);
        $response->assertStatus(401);
    }
}
