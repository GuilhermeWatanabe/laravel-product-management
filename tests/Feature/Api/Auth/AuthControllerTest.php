<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_register_a_new_user_and_return_a_token(): void
    {
        $newUser = [
            'name' => 'any name',
            'email' => 'anyemail@example.com',
            'password' => 'supersecret12345',
            'password_confirmation' => 'supersecret12345',
        ];

        $response = $this->postJson('/api/register', $newUser);

        $response->assertStatus(201);
        $response->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'access_token',
            ]);

        $this->assertDatabaseHas('users', ['email' => 'anyemail@example.com']);
    }

    public function test_it_fails_registration_with_invalid_data(): void
    {
        $newUser = [
            'name' => 'any name',
            'email' => 'not valid email',
            'password' => '123',
        ];

        $response = $this->postJson('/api/register', $newUser);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_it_can_login_a_user_with_correct_credentials_and_return_a_token(): void
    {
        $user = User::factory()->create(['password' => bcrypt('supersecret12345')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'supersecret12345'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'access_token']);
    }

    public function test_it_fails_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('supersecret12345')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Credenciais inválidas.']);
    }

    public function test_it_can_logout_an_authenticated_user_and_invalidate_the_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson('/api/logout');
        $response1->assertStatus(200);
        $response1->assertJson(['message' => 'Logout.']);
    }

    public function test_it_prevents_unauthenticated_users_from_logging_out(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }
}
