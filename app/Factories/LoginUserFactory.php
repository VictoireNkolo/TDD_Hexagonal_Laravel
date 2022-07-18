<?php

namespace App\Factories;

use Illuminate\Http\Request;
use Module\Application\Auth\Login\LoginCommand;

class LoginUserFactory
{

    public static function buildLoginCommandFormRequest(Request $request) : LoginCommand {
        $loginCommand = new LoginCommand();
        $loginCommand->email = $request->get('email');
        $loginCommand->password = $request->get('password');

        return $loginCommand;
    }
}
