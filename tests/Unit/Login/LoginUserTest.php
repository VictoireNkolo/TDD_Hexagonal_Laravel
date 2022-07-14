<?php

namespace Tests\Unit\Login;

use Module\Application\Auth\Login\LoginUser;
use Module\Infrastructure\Auth\AuthRepositoryInMemory;
use Module\Infrastructure\Auth\PasswordProviderInMemory;
use PHPUnit\Framework\TestCase;

class LoginUserTest extends TestCase
{
    private AuthRepositoryInMemory $authRepository;
    private PasswordProviderInMemory $passwordProvider;

    public function setUp(): void {
        parent::setUp();
        $this->authRepository = new AuthRepositoryInMemory();
        $this->passwordProvider = new PasswordProviderInMemory();
    }

    public function test_user_can_login() {
        $loginCommand = LoginCommandBuilder::prepare()->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertTrue($loginResponse->auth->isLogged());
        $this->assertEquals("Utilisateur connecté avec succès.", $loginResponse->auth->loggedMessage());
    }

    public function test_user_tries_login_with_wrong_credentials() {
        $loginCommand = LoginCommandBuilder::prepare()
            ->withEmail('blabla@gmail.com')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertFalse($loginResponse->auth->isLogged());
        $this->assertEquals("Cet utilisateur n'existe pas !", $loginResponse->auth->loggedMessage());
    }

    public function test_user_tries_login_with_wrong_password() {
        $loginCommand = LoginCommandBuilder::prepare()
            ->withPassword('111111')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertFalse($loginResponse->auth->isLogged());
        $this->assertEquals("Mot de passe incorrect !", $loginResponse->auth->loggedMessage());
    }

    public function test_user_tries_login_with_invalid_email() {

    }

    public function test_user_tries_login_with_invalid_password() {

    }

}
