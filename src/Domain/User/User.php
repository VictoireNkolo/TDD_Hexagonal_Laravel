<?php

namespace Module\Domain\User;


use Module\Domain\User\Exceptions\ErrorUserException;

class User
{

    private string $name;
    private string $email;
    private string $role;
    private bool $isSaved;
    private string $savingMessage;

    public function __construct()
    {
        $this->isSaved = false;
        $this->savingMessage = '';
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $role
     * @return User
     */
    public static function compose(
        string $name,
        string $email,
        string $role
    ) : User
    {
        $self = new static();
        $self->name = $name;
        $self->email = $email;
        $self->role = $role;
        $self->validateEmail();
        $self->validateName();
        $self->validateRole();

        return $self;
    }

    public function savingFeedback(bool $isSaved) : string
    {
        $this->isSaved = $isSaved;
        if (!$isSaved) {
            $this->savingMessage = "Opération échouée";
            return $this->savingMessage;
        }
        $this->savingMessage = "Utiliateur enregistré avec succès";

        return $this->savingMessage;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isSaved(): bool
    {
        return $this->isSaved;
    }

    /**
     * @return string
     */
    public function savingMessage(): string
    {
        return $this->savingMessage;
    }

    private function validateEmail()
    {
        if (!$this->email) {
            throw new ErrorUserException("L'email de l'utilisateur est obligatoire !");
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new ErrorUserException("$this->email : email non valide !");
        }
    }

    private function validateName()
    {
        if (!$this->name) {
            throw new ErrorUserException("Le nom de l'utilisateur est obligatoire !");
        }
    }

    private function validateRole()
    {
        if (!$this->role) {
            throw new ErrorUserException("Le rôle de l'utilisateur est obligatoire !");
        }
    }
}
