<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithFaker;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_task()
    {
        $this->signIn();
        $name        = $this->faker->text(100);
        $description = $this->faker->text(255);
        $response    = $this->post('/api/v1/task', ['name' => $name, 'description' => $description], ['Accept' => 'application/json']);
        $response->assertCreated();
        $response->assertJsonStructure(['data' => ['id', 'name', 'description', 'name', 'updated_at', 'created_at']]);
    }

    public function test_create_task_invalid_inputs()
    {
        $user        = $this->signIn();
        $task        = Task::factory(['user_id' => $user->id])->create();
        $name        = $this->faker->unique->realTextBetween(256, 300);
        $description = $this->faker->unique->realTextBetween(256, 300);
        $response    = $this->post('/api/v1/task', ['name' => $name, 'description' => $description], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'description']);

        $response = $this->post('/api/v1/task', [], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_task()
    {
        $user        = $this->signIn();
        $task        = Task::factory(['user_id' => $user->id])->create();
        $name        = $this->faker->unique->text(100);
        $description = $this->faker->unique->text(255);
        $response    = $this->put('/api/v1/task/' . $task->id, ['name' => $name, 'description' => $description], ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_update_task_invalid_inputs()
    {
        $user        = $this->signIn();
        $task        = Task::factory(['user_id' => $user->id])->create();
        $name        = $this->faker->unique->realTextBetween(256, 300);
        $description = $this->faker->unique->realTextBetween(256, 300);
        $invalidId   = ($task->id + 10);
        $response    = $this->put('/api/v1/task/' . $invalidId, ['name' => $name, 'description' => $description], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'id'          => 'The selected id is invalid.',
            'name'        => 'The name must not be greater than 255 characters.',
            'description' => 'The description must not be greater than 255 characters.'
        ]);

        $response = $this->put('/api/v1/task/' . $invalidId, [], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id' => 'The selected id is invalid.', 'name' => 'The name field is required.']);
    }
}
