<?php

namespace tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use app\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that registration fails with invalid input data.
     */
    public function test_register_validation_fails()
    {
        // Simulate a POST request to the register endpoint with invalid data
        $response = $this->postJson('/api/register', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'notmatching',
        ]);

        // Assert that validation errors are returned
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password']);
    }

    /**
     * Test that a user is successfully created upon valid registration.
     */
    public function test_register_creates_user()
    {
        // Simulate a POST request with valid registration data
        $response = $this->postJson('/api/register', [
            'first_name' => 'Sintayu',
            'last_name' => 'de Kuiper',
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Assert that the response is successful and has the expected structure
        $response->assertStatus(201);
        $response->assertJsonStructure(['message', 'user', 'token']);

        // Verify that the user was created in the database
        $this->assertDatabaseHas('users', [
            'email' => 'sintayu.de.kuiper@example.com',
        ]);
    }

    /**
     * Test that login fails with an invalid email address.
     */
    public function test_login_with_invalid_email()
    {
        // Simulate a POST request to the login endpoint with a non-existent email
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        // Assert that the response indicates unauthorized access
        $response->assertStatus(422);
        $response->assertJson([
            'error' => 'A user with the provided email address could not be found.',
        ]);
    }

    /**
     * Test that login fails with an incorrect password.
     */
    public function test_login_with_invalid_password()
    {
        // Create a user with a known password
        $user = User::factory()->create([
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => Hash::make('correct_password'),
        ]);

        // Attempt to login with the wrong password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        // Assert that the response indicates unauthorized access
        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'The provided password is incorrect.',
        ]);
    }

    /**
     * Test that a user can successfully log in with valid credentials.
     */
    public function test_login_successful()
    {
        // Create a user with a known password
        $user = User::factory()->create([
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => Hash::make('correct_password'),
        ]);

        // Attempt to login with the correct credentials
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'correct_password',
        ]);

        // Assert that the response is successful and contains the expected data
        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);
    }

    /**
     * Test that a user can successfully log out.
     */
    public function test_logout_successful()
    {
        // Create a user and generate a token
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Simulate an authenticated POST request to the logout endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        // Assert that the response indicates a successful logout
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logout successful!',
        ]);

        // Verify that the token was deleted from the database
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }
}
