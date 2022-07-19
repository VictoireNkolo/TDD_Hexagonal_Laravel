<?php

namespace Tests\Shared\User;

use Module\Application\User\SaveUserCommand;

class SaveUserCommandBuilder extends SaveUserCommand
{
    public string $name = "John";
    public string $email = "john@gmail.com";
    public string $role = "admin";

    public static function asUser() : SaveUserCommandBuilder {
        return new static();
    }

    public function build() : SaveUserCommand {
        $saveUserCommand = new SaveUserCommand();
        $saveUserCommand->name = $this->name;
        $saveUserCommand->email = $this->email;
        $saveUserCommand->role = $this->role;

        return $saveUserCommand;
    }

    public function withName(string $name) : SaveUserCommandBuilder {
        $this->name = $name;

        return $this;
    }

    public function withEmail(string $email) : SaveUserCommandBuilder {
        $this->email = $email;

        return $this;
    }

    public function withRole(string $role)
    {
        $this->role = $role;

        return $this;
    }
}
