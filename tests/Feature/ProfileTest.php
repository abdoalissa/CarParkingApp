<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{


    
    /**
     * A basic feature test example.
     */
      use RefreshDatabase;
 
    public function testUserCanGetTheirProfile()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)->getJson('/api/v1/profile');
 
        $response->assertStatus(200)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => $user->name]);
    }
 
    public function testUserCanUpdateNameAndEmail()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name'  => 'John Updated',
            'email' => 'john_updated@example.com',
        ]);
 
        $response->assertStatus(202)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => 'John Updated']);
 
        $this->assertDatabaseHas('users', [
            'name'  => 'John Updated',
            'email' => 'john_updated@example.com',
        ]);
    }
 
    public function testUserCanChangePassword()
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password'      => 'password',
            'password'              => 'testing123',
            'password_confirmation' => 'testing123',
        ]);
 
        $response->assertStatus(202);
    }
}
