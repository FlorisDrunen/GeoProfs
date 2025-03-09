<?php

namespace tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Tests that a user is successfully created with a correct role.
     */
    public function test_register_user_with_permission_officemanager()
    {
        $adminUser = User::factory()->create([
            'rol' => 'officemanager', 
        ]);
    
        $this->actingAs($adminUser); 
    
        $response = $this->postJson('/api/register', [
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
    
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'Voornaam@mail.com',
        ]);
    }

    /**
     * Tests that a user connot successfully be created without a correct role.
     */
    public function test_register_user_without_permission_werknemer()
    {
        $adminUser = User::factory()->create([
            'rol' => 'werknemer', 
        ]);
    
        $this->actingAs($adminUser);
    
        $response = $this->postJson('/api/register', [
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
    
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHasErrors(['error']);
        $this->assertDatabaseMissing('users', [
            'email' => 'Voornaam@mail.com',
        ]);
    }

    /**
     * Tests that a user connot successfully be created without a correct role.
     */
    public function test_register_user_without_permission_teammanager()
    {
        $adminUser = User::factory()->create([
            'rol' => 'teammanager', 
        ]);
    
        $this->actingAs($adminUser); 
    
        $response = $this->postJson('/api/register', [
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
    
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHasErrors(['error']);
        $this->assertDatabaseMissing('users', [
            'email' => 'Voornaam@mail.com',
        ]);
    }

    /**
     * Tests if a user cannot be created with an officemanager role.
     */
    public function test_register_user_with_impossible_role()
    {
        
        $adminUser = User::factory()->create([
            'rol' => 'officemanager', 
        ]);
    
        $this->actingAs($adminUser); 
    
        
        $response = $this->postJson('/api/register', [
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'officemanager',
            'email' => 'Voornaam@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
    
        $response->assertStatus(422); //Invalid data
        $this->assertDatabaseMissing('users', [
            'email' => 'Voornaam@mail.com',
        ]);
    }
    
    /**
     * Test if login fails with an incorrect password.
     */
    public function test_login_with_invalid_password()
    {
       
        $user = User::factory()->create([
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => Hash::make('correct_password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'Voornaam@mail.com',
            'password' => 'wrong_password',
        ]);

        
        $response->assertStatus(401); //Unauthorized
    }

    /**
     * Test that login fails with an invalid email address.
     */
    public function test_login_with_invalid_email()
    {

        $user = User::factory()->create([
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => Hash::make('correct_password'),
        ]);
        
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'correct_password',
        ]);

        $response->assertStatus(422); //Invalid data
    }

     /**
     * Test that a user can successfully log in with valid credentials.
     */
    public function test_login_successful()
    {
        
        $user = User::factory()->create([
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => Hash::make('correct_password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'Voornaam@mail.com',
            'password' => 'correct_password',
        ]);

        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('dashboard'));
    }

      /**
     * Test if user needs to be logged in to log out.
     */

     public function test_logout_unsuccessful(){

        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }

     /**
     * Test if user needs to be logged in to log out.
     */
    public function test_logout_successful(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(302); //Authorized
        $response->assertRedirect(route('login'));
    }

}
