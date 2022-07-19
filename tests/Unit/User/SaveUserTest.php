<?php

namespace Tests\Unit\User;

use Module\Application\User\SaveUser;
use Module\Domain\User\Exceptions\ErrorUserException;
use Module\Infrastructure\User\UserRepositoryInMemory;
use Tests\Shared\User\SaveUserCommandBuilder;
use Tests\TestCase;

class SaveUserTest extends TestCase
{
    public UserRepositoryInMemory $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepositoryInMemory();
    }

    public function test_user_can_be_created() {
        $saveUserCommand = SaveUserCommandBuilder::asUser()->build();
        $saveUser = new SaveUser($this->userRepository);
        $saveUserResponse = $saveUser->__invoke($saveUserCommand);

        $this->assertTrue($saveUserResponse->isSaved);
        $this->assertEquals("Utiliateur enregistré avec succès", $saveUserResponse->savingMessage);
    }

    public function test_creation_of_a_user_with_invalid_email() {
        $saveUserCommand = SaveUserCommandBuilder::asUser()
            ->withEmail('azeaze.eko')
            ->build();
        $saveUser = new SaveUser($this->userRepository);
        $this->expectException(ErrorUserException::class);
        $this->expectExceptionMessage("$saveUserCommand->email : email non valide");
        $saveUserResponse = $saveUser->__invoke($saveUserCommand);
    }

    public function test_creation_of_a_user_with_empty_email() {
        $saveUserCommand = SaveUserCommandBuilder::asUser()
            ->withEmail('')
            ->build();
        $saveUser = new SaveUser($this->userRepository);
        $this->expectException(ErrorUserException::class);
        $this->expectExceptionMessage("L'email de l'utilisateur est obligatoire !");
        $saveUserResponse = $saveUser->__invoke($saveUserCommand);
    }

    public function test_creation_of_a_user_with_empty_name() {
        $saveUserCommand = SaveUserCommandBuilder::asUser()
            ->withName('')
            ->build();
        $saveUser = new SaveUser($this->userRepository);
        $this->expectException(ErrorUserException::class);
        $this->expectExceptionMessage("Le nom de l'utilisateur est obligatoire !");
        $saveUserResponse = $saveUser->__invoke($saveUserCommand);
    }

    public function test_creation_of_a_user_with_empty_role() {
        $saveUserCommand = SaveUserCommandBuilder::asUser()
            ->withRole('')
            ->build();
        $saveUser = new SaveUser($this->userRepository);
        $this->expectException(ErrorUserException::class);
        $this->expectExceptionMessage("Le rôle de l'utilisateur est obligatoire !");
        $saveUserResponse = $saveUser->__invoke($saveUserCommand);
    }
}
