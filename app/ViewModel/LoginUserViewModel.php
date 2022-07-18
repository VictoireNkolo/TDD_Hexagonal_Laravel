<?php

namespace App\ViewModel;

use Illuminate\Http\JsonResponse;
use Module\Application\Auth\Login\LoginResponse;

class LoginUserViewModel extends ViewModel
{
    public string $message;
    public string $isLogged;

    public function __construct()
    {
        $this->message = '';
        $this->isLogged = false;
    }

    /**
     * @param LoginResponse $response
     */
    public function present(LoginResponse $response) : void {
        $auth = $response->auth;
        $this->message = $auth?->loggedMessage();
        $this->isLogged = $auth?->isLogged();
    }

    public function viewModel() : JsonResponse {
        return $this->response(
            [
                'message' => $this->message,
                'isLogged' => $this->isLogged
            ]
        );
    }
}
