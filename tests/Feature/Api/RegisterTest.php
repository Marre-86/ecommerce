<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spectator\Spectator;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');
    }

    public function testRegisterOk(): void
    {
        $input = [
            'name' => 'Artem',
            'email' => 'artempokhiliuk@yahoo.com',
            'password' => '123f',
            'c_password' => '123f'
        ];

        $response = $this->postJson('/api/v1/register', $input);

        $response
            ->assertValidRequest()
            ->assertValidResponse(200);

        $this->assertDatabaseHas('users', [
            'name' => 'Artem', 'email' => 'artempokhiliuk@yahoo.com'
        ]);
    }

    public function testRegisterErrorIfEmptyName(): void
    {
        $input = [
            'name' => '',
            'email' => 'artempokhiliuk@yahoo.com',
            'password' => '123f',
            'c_password' => '123f'
        ];

        $response = $this->postJson('/api/v1/register', $input);

        $response
            ->assertValidResponse(400);
    }

    public function testRegisterErrorIfPasswordsMismatch(): void
    {
        $input = [
            'name' => 'Artem',
            'email' => 'artempokhiliuk@yahoo.com',
            'password' => '123f',
            'c_password' => '123fe'
        ];

        $response = $this->postJson('/api/v1/register', $input);

        $response
            ->assertValidResponse(400);
    }

    public function testRegisterErrorIfEmailExists(): void
    {
        User::create([
            'name' => 'Gosha Bykov',
            'email' => 'gosha@bykov.com',
            'password' => 'goga'
        ]);

        $input = [
            'name' => 'Artem',
            'email' => 'gosha@bykov.com',
            'password' => '123fe',
            'c_password' => '123fe'
        ];

        $response = $this->postJson('/api/v1/register', $input);

        $response
            ->assertValidResponse(400);
    }

    public function testIssuedTokenIsValid(): void
    {
        $input = [
            'name' => 'Artem',
            'email' => 'artempokhiliuk@yahoo.com',
            'password' => '123f',
            'c_password' => '123f'
        ];

        $responseSignUp = $this->postJson('/api/v1/register', $input);

        $newCategory = [
            'name' => 'Galoshi',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$responseSignUp['data']['token']}",
        ])->postJson('/api/v1/category', $newCategory);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($newCategory);
    }
}
