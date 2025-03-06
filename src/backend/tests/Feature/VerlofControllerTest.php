<?php

namespace tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;
use App\Models\Verlof;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerlofControllerTest extends TestCase
{
    use RefreshDatabase;
    
     /**
     * Test if verlof is successfully created with proper roles.
     */
    public function test_create_verlof_with_permission_werknemer()
    {
        $adminUser = User::factory()->create([
            'rol' => 'werknemer', 
        ]);
    
        $this->actingAs($adminUser); 

        $response = $this->postJson('/api/verlof-nieuw', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '11:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '14:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('verlofOverzicht'));

        $this->assertDatabaseHas('verlof', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '11:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '14:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    }


     /**
     * Test if verlof is unsuccessfully created without proper roles(teammanager).
     */
    public function test_create_verlof_without_permission_teammanager()
    {
        $adminUser = User::factory()->create([
            'rol' => 'teammanager', 
        ]);
    
        $this->actingAs($adminUser); 

        $response = $this->postJson('/api/verlof-nieuw', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '12:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '15:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    
        $response->assertStatus(302); //Unauthorized
        $response->assertSessionHasErrors(['error']);
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('verlof', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '12:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '15:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    }

    /**
     * Test if verlof is unsuccessfully created without proper roles(officemanager).
     */
    public function test_create_verlof_without_permission_officemanager()
    {
        $adminUser = User::factory()->create([
            'rol' => 'officemanager', 
        ]);
    
        $this->actingAs($adminUser); 

        $response = $this->postJson('/api/verlof-nieuw', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '13:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '16:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    
        $response->assertStatus(302); //Unauthorized
        $response->assertSessionHasErrors(['error']);
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('verlof', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '13:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '16:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    }

    /**
     * Test if verlof can be deleted.
     */
    public function test_delete_verlof()
    {
        $adminUser = User::factory()->create([
            'rol' => 'werknemer', 
        ]);
    
        $this->actingAs($adminUser); 

        $response = $this->postJson('/api/verlof-nieuw', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '14:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '17:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('verlof', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '14:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '17:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);

        $response = $this->deleteJson('/api/verlof-delete/1');
    
        $response->assertStatus(302); //redirect
        $response->assertRedirect(route('verlofOverzicht'));
        $this->assertDatabaseMissing('verlof', [
            'user_id' => $adminUser->id,
            'begin_tijd' => '14:51',
            'begin_datum' => '2025-10-10',
            'eind_tijd' => '17:22',
            'eind_datum' => '2025-11-13',
            'reden' => 'Ik wil verlof',
            'status' => 'pending'
        ]);
    }

    /**
     * Test if the person who requested verlof can edit their request.
     */
    public function test_owner_can_update_verlof_request()
    {
        
        $user = User::factory()->create();
        $verlof = Verlof::factory()->create([
            'user_id' => $user->id,
            'begin_tijd' => '10:00',
            'begin_datum' => '2025-05-01',
            'eind_tijd' => '12:00',
            'eind_datum' => '2025-05-01',
            'reden' => 'Oorspronkelijke reden',
            'status' => 'pending',
        ]);

        $this->actingAs($user);

        $response = $this->putJson(route('verlofUpdatenFunc', $verlof->id), [
            'begin_tijd' => '11:00',
            'begin_datum' => '2025-05-02',
            'eind_tijd' => '13:00',
            'eind_datum' => '2025-05-02',
            'reden' => 'Gewijzigde reden',
            'status' => 'approved',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('verlofOverzicht'));
        $this->assertDatabaseHas('verlof', [
            'id' => $verlof->id,
            'begin_tijd' => '11:00',
            'begin_datum' => '2025-05-02',
            'eind_tijd' => '13:00',
            'eind_datum' => '2025-05-02',
            'reden' => 'Gewijzigde reden',
            'status' => 'approved',
        ]);
    }

    /**
     * Test if the person who isn't the one who requested verlof can edit their request.
     */
    //Test mislukt omdat het geen rol checks noch error handling heeft.
    public function test_non_owner_cannot_update_verlof_request()
    {

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $verlof = Verlof::factory()->create([
            'user_id' => $owner->id,
            'begin_tijd' => '10:00',
            'begin_datum' => '2025-05-01',
            'eind_tijd' => '12:00',
            'eind_datum' => '2025-05-01',
            'reden' => 'Oorspronkelijke reden',
            'status' => 'pending',
        ]);

        $this->actingAs($otherUser);

        $response = $this->putJson(route('verlofUpdatenFunc', $verlof->id), [
            'begin_tijd' => '11:00',
            'begin_datum' => '2025-05-02',
            'eind_tijd' => '13:00',
            'eind_datum' => '2025-05-02',
            'reden' => 'Illegale wijziging',
            'status' => 'approved',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));   
        $response->assertSessionHasErrors(['error']);     
        $this->assertDatabaseMissing('verlof', [
            'id' => $verlof->id,
            'reden' => 'Illegale wijziging',
        ]);
    }

}
