<?php

namespace App\Http\Controllers\Auth;

use App\Factories\LoginUserFactory;
use App\Http\Request\LoginUserRequest;
use App\ViewModel\LoginUserViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Module\Application\Auth\Login\LoginCommand;
use Module\Application\Auth\Login\LoginUser;
use Module\Domain\Auth\Exceptions\ErrorAuthException;

class LoginUserAction
{
    public function __invoke(
        LoginUserRequest $userRequest,
        LoginUser   $loginUser
    ) : JsonResponse
    {
        $loginCommand = LoginUserFactory::buildLoginCommandFormRequest($userRequest);
        $viewModel = new LoginUserViewModel();
        try {
            $response = $loginUser->__invoke($loginCommand);
            $viewModel->present($response);
            $this->authLogin($loginCommand, $response->auth?->isLogged());
        } catch (ErrorAuthException $e) {
            $viewModel->message = $e->getMessage();
        }

        return $viewModel->viewModel();
    }

    /**
     *
     * @param LoginCommand $loginCommand
     * @param bool $isLogged
     */
    private function authLogin(LoginCommand $loginCommand, bool $isLogged) : void {
        if ($isLogged) {
            Auth::attempt([
                'email' => $loginCommand->email,
                'password' => $loginCommand->password
            ]);
        }
    }
}
