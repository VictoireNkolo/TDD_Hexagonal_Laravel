<?php

namespace Module\Domain\Auth;

interface PasswordProvider
{
    public function crypt(string $password): string;
    public function check(string $password, string $passwordHash): bool;
}
