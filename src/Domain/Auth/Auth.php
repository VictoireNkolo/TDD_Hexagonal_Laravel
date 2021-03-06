<?php

namespace Module\Domain\Auth;

use Module\Domain\Auth\Exceptions\ErrorAuthException;

class Auth
{
    private string $email;
    private string $password;
    private string $passwordHashed;
    private bool $isLogged;
    private string $loggedMessage;
    private PasswordProvider $passwordProvider;

    public function __construct(string $email, string $password)
    {
        $this->isLogged = false;
    }

    /**
     * @param string $email
     * @param string $password
     * @param PasswordProvider $passwordProvider
     * @return Auth
     */
    public static function compose(string $email, string $password, PasswordProvider $passwordProvider): Auth
    {
        $self = new static($email, $password);
        $self->email = $email;
        $self->password = $password;
        $self->passwordHashed = $passwordProvider->crypt($password);
        $self->passwordProvider = $passwordProvider;
        $self->validateEmail();
        $self->validatePassword();

        return $self;
    }

    /**
     * @param AuthResult $authResult
     */
    public function login(AuthResult $authResult): void
    {
        if (!$authResult->getEmail()) {
            $this->loggedMessage = "Cet utilisateur n'existe pas !";
            return;
        }
        if (
            !$this->passwordProvider->check(
                $this->password,
                $authResult->getPassword()
            )
        ) {
            $this->loggedMessage = "Mot de passe incorrect !";
            return;
        }
        $this->loggedMessage = "Utilisateur connecté avec succès.";
        $this->isLogged = true;
    }

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->isLogged;
    }

    /**
     * @return string
     */
    public function loggedMessage(): string
    {
        return $this->loggedMessage;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return void
     */
    private function validateEmail() : void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new ErrorAuthException("$this->email : email non valide !");
        }
    }

    /**
     * @return void
     */
    private function validatePassword() : void
    {
        if (!$this->password) {
            throw new ErrorAuthException("Le mot de passe doit être non vide !");
        }
        if (strlen($this->password) < 5) {
            throw new ErrorAuthException("$this->password : mot de passe non valide !");
        }
    }

}
