<?php

namespace Tests\Unit\Login;

use Module\Application\Auth\Login\LoginUser;
use Module\Infrastructure\Auth\AuthRepositoryInMemory;
use Module\Domain\Auth\Exceptions\ErrorAuthException;
use Module\Infrastructure\Auth\PasswordProviderInMemory;
use PHPUnit\Framework\TestCase;
use Tests\Shared\Login\LoginCommandBuilder;

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
        $loginCommand = LoginCommandBuilder::prepare()
            ->withEmail('blablagmail.com')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $this->expectException(ErrorAuthException::class);
        $this->expectExceptionMessage("$loginCommand->email : email non valide !");
        $loginResponse = $loginUser->__invoke($loginCommand);
    }

    public function test_user_tries_login_with_empty_password() {
        $loginCommand = LoginCommandBuilder::prepare()
            ->withPassword('')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $this->expectException(ErrorAuthException::class);
        $this->expectExceptionMessage("Le mot de passe doit être non vide !");
        $loginResponse = $loginUser->__invoke($loginCommand);
    }

    public function test_user_tries_login_with_invalid_password() {
        $loginCommand = LoginCommandBuilder::prepare()
            ->withPassword('1111')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $this->expectException(ErrorAuthException::class);
        $this->expectExceptionMessage("$loginCommand->password : mot de passe non valide !");
        $loginResponse = $loginUser->__invoke($loginCommand);
    }

}
