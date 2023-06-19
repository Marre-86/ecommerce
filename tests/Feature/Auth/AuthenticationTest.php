<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginScreenCanBeRendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUsersCanAuthenticateUsingTheLoginScreen(): void
    {
        $user = User::factory()->create();
   //     dd($user);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
    public function testCannotTryToLoginMoreThanFiveTimesInARow()
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= 5; $i += 1) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => false,
        ]);

        $this->assertGuest();
    }
}
