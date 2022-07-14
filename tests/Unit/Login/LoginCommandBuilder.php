<?php

namespace Tests\Unit\Login;

use Module\Application\Auth\Login\LoginCommand;
use phpDocumentor\Reflection\Types\Static_;

class LoginCommandBuilder extends LoginCommand
{
    public string $email = 'test0@gmail.com';
    public string $password = '123456';

    public static function prepare(): LoginCommandBuilder
    {
        return new static();
    }

    /**
     * @return LoginCommand
     */
    public function build(): LoginCommand
    {
        $loginCommand = new LoginCommand();
        $loginCommand->email = $this->email;
        $loginCommand->password = $this->password;

        return $loginCommand;
    }

    public function withEmail(string $email) : LoginCommandBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function withPassword(string $password) : LoginCommandBuilder
    {
        $this->password = $password;
        return $this;
    }
}
