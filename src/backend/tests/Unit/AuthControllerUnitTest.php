<?php

namespace tests\Unit;

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_validation_fails()
    {
        $authController = new AuthController();

        $request = new Request([
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'notmatching',
        ]);

        $this->expectException(ValidationException::class);

        $authController->register($request);
    }

    public function test_register_creates_user()
    {
        $controller = new AuthController();

        $request = new Request([
            'first_name' => 'Sintayu',
            'last_name' => 'de Kuiper',
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response = $controller->register($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('message', $response->getData(true));
        $this->assertArrayHasKey('user', $response->getData(true));
        $this->assertArrayHasKey('token', $response->getData(true));
    }

    public function test_login_with_invalid_email()
    {
        $controller = new AuthController();
        $request = new Request([
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response = $controller->login($request);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals(
            'A user with the provided email address could not be found.',
            $response->getData(true)['error']
        );
    }

    public function test_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => Hash::make('correct_password'),
        ]);

        $controller = new AuthController();
        $request = new Request([
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response = $controller->login($request);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('The provided password is incorrect.', $response->getData(true)['error']);
    }

    public function test_login_successful()
    {
        $user = User::factory()->create([
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => Hash::make('correct_password'),
        ]);

        $controller = new AuthController();
        $request = new Request([
            'email' => $user->email,
            'password' => 'correct_password',
        ]);

        $response = $controller->login($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('user', $response->getData(true));
        $this->assertArrayHasKey('token', $response->getData(true));
    }

    public function test_logout_successful()
    {
        $user = User::factory()->create();
        $controller = new AuthController();

        // Simulate a request with an authenticated user
        $request = Request::create('/api/logout', 'POST');
        $request->setUserResolver(fn () => $user);

        // Ensure user tokens are created and then deleted
        $user->createToken('test')->plainTextToken;

        $response = $controller->logout($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Logout successfull!', $response->getData(true)['message']);
        $this->assertDatabaseMissing('personal_access_tokens', ['tokenable_id' => $user->id]);
    }
}

