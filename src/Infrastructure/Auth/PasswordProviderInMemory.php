<?php

namespace Module\Infrastructure\Auth;

use Module\Domain\Auth\PasswordProvider;

class PasswordProviderInMemory implements PasswordProvider
{
    private string $password;

    public function __construct()
    {
    }

    /**
     * @param string $password
     * @return string
     */
    public function crypt(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @param string $passwordHash
     * @return bool
     */
    public function check(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }
}
