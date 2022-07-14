<?php

namespace Module\Application\Auth\Login;

use Module\Domain\Auth\Auth;

class LoginResponse
{
    public ?Auth $auth = null;
}
