<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spectator\Spectator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');

        User::create([
            'name' => 'Gosha Bykov',
            'email' => 'gosha@bykov.com',
            'password' => Hash::make('goga')
        ]);
    }

    public function testLoginOk(): void
    {
        $input = [
            'email' => 'gosha@bykov.com',
            'password' => 'goga'
        ];

        $response = $this->postJson('/api/v1/login', $input);

        $response
            ->assertValidRequest()
            ->assertValidResponse(200);
    }

    public function testLoginErrorIfPasswordsMismatch(): void
    {
        $input = [
            'email' => 'gosha@bykov.com',
            'password' => 'gaga'
        ];

        $response = $this->postJson('/api/v1/login', $input);

        $response
            ->assertValidResponse(401);
    }

    // note that here, unlike in RegisterTest, we should not manually attach Token in the request header
    // because of this (if I'm not mistaken):
    // "Sanctum will first determine if the request includes a session cookie that references an authenticated
    //  session. Sanctum accomplishes this by calling Laravel's built-in authentication services"
    public function testCanUseProtectedResourseAfterLogin(): void
    {
        $input = [
            'email' => 'gosha@bykov.com',
            'password' => 'goga'
        ];

        $responseLogin = $this->postJson('/api/v1/login', $input);

        $newCategory = [
            'name' => 'Galoshi',
        ];

        $response = $this->postJson('/api/v1/category', $newCategory);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($newCategory);
    }
}
