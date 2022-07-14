<?php

namespace Module\Infrastructure\Auth;

use Module\Domain\Auth\Auth;
use Module\Domain\Auth\AuthRepository;
use Module\Domain\Auth\AuthResult;

class AuthRepositoryInMemory implements AuthRepository
{
    /**
     * @var UserInMemory[]
     */
    private array $users = array();

    public function __construct()
    {
        $passwordHash = new PasswordProviderInMemory();
        $passwordHashed = $passwordHash->crypt('123456');

        $this->users[] = new UserInMemory('test0@gmail.com', $passwordHashed);
        $this->users[] = new UserInMemory('test1@gmail.com', $passwordHashed);
        $this->users[] = new UserInMemory('test2@gmail.com', $passwordHashed);
        $this->users[] = new UserInMemory('test3@gmail.com', $passwordHashed);
    }

    public function getByCredentials(Auth $auth): AuthResult
    {
        $userToFind = null;
        foreach ($this->users as $user){
            if ($user->getEmail() === $auth->getEmail()){
                $userToFind = $user;
                break;
            }
        }
        if ($userToFind){
            return new AuthResult($userToFind->getEmail(), $userToFind->getPassword());
        }
        return new AuthResult(null, null);
    }
}
