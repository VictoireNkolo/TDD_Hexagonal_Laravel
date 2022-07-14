<?php

namespace Module\Domain\Auth;

interface AuthRepository
{
    public function getByCredentials(Auth $auth): AuthResult;
}
