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
        // Maak een gebruiker met de juiste rol aan en log deze in
        $adminUser = User::factory()->create([
            'rol' => 'officemanager', // Zorg ervoor dat de gebruiker mag registreren
        ]);
    
        $this->actingAs($adminUser); // Simuleer een ingelogde gebruiker
    
        // Simuleer een POST-request met geldige registratiegegevens
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
        // Maak een gebruiker met de juiste rol aan en log deze in
        $adminUser = User::factory()->create([
            'rol' => 'werknemer', // Zorg ervoor dat de gebruiker mag registreren
        ]);
    
        $this->actingAs($adminUser); // Simuleer een ingelogde gebruiker
    
        // Simuleer een POST-request met geldige registratiegegevens
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
        // Maak een gebruiker met de juiste rol aan en log deze in
        $adminUser = User::factory()->create([
            'rol' => 'teammanager', // Zorg ervoor dat de gebruiker mag registreren
        ]);
    
        $this->actingAs($adminUser); // Simuleer een ingelogde gebruiker
    
        // Simuleer een POST-request met geldige registratiegegevens
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
        // Maak een gebruiker met de juiste rol aan en log deze in
        $adminUser = User::factory()->create([
            'rol' => 'officemanager', // Zorg ervoor dat de gebruiker mag registreren
        ]);
    
        $this->actingAs($adminUser); // Simuleer een ingelogde gebruiker
    
        // Simuleer een POST-request met geldige registratiegegevens
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

        $adminUser = User::factory()->create([
            'rol' => 'officemanager', 
        ]);
    
        $this->actingAs($adminUser); 
        
        // Create a user with a known password
        $user = User::factory()->create([
            'first_name' => 'Voornaam',
            'last_name' => 'Achternaam',
            'rol' => 'werknemer',
            'email' => 'Voornaam@mail.com',
            'password' => Hash::make('correct_password'),
        ]);

        // Attempt to login with the wrong password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        // Assert that the response indicates unauthorized access
        $response->assertStatus(401); //Unauthorized
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
        $response->assertStatus(422); //Invalid data
    }

     /**
     * Test that a user can successfully log in with valid credentials.
     */
    public function test_login_successful()
    {
        // Create a user with a known password
        $user = User::factory()->create([
            'first_name' => 'first name',
            'last_name' => 'last name',
            'rol' => 'werknemer',
            'email' => 'sintayu.de.kuiper@example.com',
            'password' => Hash::make('correct_password'),
        ]);

        // Attempt to login with the correct credentials
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'correct_password',
        ]);

        // Assert that the response is successful and contains the expected data
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('dashboard'));
    }

      /**
     * Test if user needs to be logged in to log out.
     */

     public function test_logout_unsuccessful(){

        // Simulate an unauthenticated POST request to the logout endpoint
        $response = $this->postJson('/api/logout');

        // Assert that the response indicates a unsuccessful logout
        $response->assertStatus(401); //Unauthorized
    }

    public function test_logout_successful(){
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate an authenticated POST request to the logout endpoint
        $response = $this->postJson('/api/logout');

        // Assert that the response indicates a successful logout
        $response->assertStatus(302); //Authorized
        $response->assertRedirect(route('login'));
    }

}
