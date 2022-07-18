<?php

namespace Module\Infrastructure\Auth;

use App\Models\User;
use Module\Domain\Auth\Auth;
use Module\Domain\Auth\AuthRepository;
use Module\Domain\Auth\AuthResult;

class AuthRepositoryEloquent implements AuthRepository
{
    public function getByCredentials(Auth $auth): AuthResult
    {
        $user = User::whereEmail($auth->getEmail())->first();
        if ($user) {
            return new AuthResult($user->email, $user->password);
        }
        return new AuthResult(null, null);
    }
}
