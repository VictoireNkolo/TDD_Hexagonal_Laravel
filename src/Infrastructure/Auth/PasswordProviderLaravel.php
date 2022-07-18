<?php

namespace Module\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Module\Domain\Auth\PasswordProvider;

class PasswordProviderLaravel implements PasswordProvider
{

    /**
     * @param string $password
     * @return string
     */
    public function crypt(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * @param string $password
     * @param string $passwordHash
     * @return bool
     */
    public function check(string $password, string $passwordHash): bool
    {
        return Hash::check($password, $passwordHash);
    }
}
