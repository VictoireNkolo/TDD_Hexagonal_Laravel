<?php
declare(strict_types=1);

namespace Module\Application\Auth\Login;

use Module\Domain\Auth\Auth;
use Module\Domain\Auth\AuthRepository;
use Module\Domain\Auth\PasswordProvider;

final class LoginUser
{

    private AuthRepository $authRepository;
    private PasswordProvider $passwordProvider;

    public function __construct(AuthRepository $authRepository, PasswordProvider $passwordProvider)
    {
        $this->authRepository = $authRepository;
        $this->passwordProvider = $passwordProvider;
    }

    /**
     * @param LoginCommand $loginCommand
     * @return LoginResponse
     */
    public function __invoke(LoginCommand $loginCommand): LoginResponse
    {
        $auth = Auth::compose($loginCommand->email, $loginCommand->password, $this->passwordProvider);
        $authResult = $this->authRepository->getByCredentials($auth);
        $auth->login($authResult);
        $loginResponse = new LoginResponse();
        $loginResponse->auth = $auth;

        return $loginResponse;
    }
}
