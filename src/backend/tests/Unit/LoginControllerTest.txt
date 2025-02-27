<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    /** @test */
    public function it_logs_in_with_correct_email_and_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertTrue(Auth::check());
        $response->assertRedirect('/home');
    }

    /** @test */
    public function it_fails_to_log_in_with_wrong_email_and_correct_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'wrongemail@example.com',
            'password' => 'password123',
        ]);

        $this->assertFalse(Auth::check());
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_fails_to_log_in_with_correct_email_and_wrong_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $this->assertFalse(Auth::check());
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_allows_a_user_to_log_out()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->post('/logout');
        $this->assertFalse(Auth::check());
        $response->assertRedirect('/');
    }
}
