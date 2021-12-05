<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_login()
    {
        $password = 'password';
        $user     = User::factory(['password' => Hash::make($password)])->create();
        $response = $this->post('/api/v1/login', ['email' => $user->email, 'password' => $password], ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token', 'token_type', 'expires_in']);
    }

    public function test_user_login_invalid()
    {
        $password = 'password';
        $user     = User::factory(['password' => Hash::make($password)])->create();
        $response = $this->post('/api/v1/login', ['email' => $user->email, 'password' => 'asdasdas'], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
