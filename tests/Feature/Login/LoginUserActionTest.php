<?php

namespace Login;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Infrastructure\Auth\PasswordProviderLaravel;
use Tests\TestCase;

class LoginUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        User::factory()->create([
            'email' => 'test0@gmail.com',
            'password' => (new PasswordProviderLaravel())->crypt('123456')
        ]);
    }

    public function test_user_can_login() {
        $http_response = $this->postJson('/login', [
            'email' => 'test0@gmail.com',
            'password' => '123456'
        ]);
        $http_response->assertStatus(200)
            ->assertJson(
                [
                    'message' => "Utilisateur connecté avec succès.",
                    'isLogged' => true
                ]
            );
    }

    public function test_user_tries_login_with_wrong_email_credential() {
        $response = $this->postJson('/login', [
            'email' => 'tests@gmail.com',
            'password' => '123456'
        ]);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'message' => "Cet utilisateur n'existe pas !",
                    'isLogged' => false
                ]
            );
    }

    public function test_user_tries_login_with_wrong_password_credential() {
        $response = $this->postJson('/login', [
            'email' => 'test0@gmail.com',
            'password' => '12345456'
        ]);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'message' => "Mot de passe incorrect !",
                    'isLogged' => false
                ]
            );
    }

    public function test_user_tries_login_with_invalid_email_credential() {
        $response = $this->postJson('/login', [
            'email' => 'test0gmailcom',
            'password' => '12345456'
        ]);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'email' => ["Cette adresse email n'est pas valide"],
                ]
            );
    }

    public function test_user_tries_login_with_empty_email() {
        $response = $this->postJson('/login', [
            'email' => '',
            'password' => '12345456'
        ]);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'email' => ["Veuillez entrer votre adresse email"],
                ]
            );
    }

    public function test_user_tries_login_with_empty_password() {
        $response = $this->postJson('/login', [
            'email' => 'test0@gmail.com',
            'password' => ''
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'password' => ["Veuillez entrer votre mot de passe"],
            ]);
    }
}
