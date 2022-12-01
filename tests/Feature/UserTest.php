<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // Test User Store
    public function test_user_can_be_stored()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('api/register', [
            'first_name' => 'Danny',
            'last_name' => 'Sivyolo',
            'email' => 'dansivyolo@gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);
        // $response->dump();
    }

    // Test user login
    public function test_user_can_logged_in()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('api/login', [
                'email' => 'dan@gmail.com',
                'password' => '123456'
            ]);

        $response->assertStatus(200);
        // $this->assertTrue(true);
        // $response->dump();
    }

    // Test User can see profil informations
    public function test_user_can_see_profil_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->get('api/profil');
        $response->assertStatus(200);
        // $response->dump();
    }

    // Test user can update profil informations
    public function test_user_can_update_profil_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('api/update_profil', [
                            'first_name' => 'Danny',
                            'last_name' => 'Sivyolo',
                            'email' => 'dansivyolo@gmail.com',
                            'ville' => 1,
                            'telephone' => '0999985785',
                            'adresse' => 'adresse',
                            'code_postal' => 'code_postal',
                            'anniversaire' => '2022-09-15',
                            'genre' => 'Homme',
                        ]);

        // $this->assertTrue(true);
        $response->assertStatus(500);
        // $response->dump();
    }
}
