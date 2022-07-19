<?php

namespace Module\Domain\User;

Interface UserRepository
{
    public function save (User $user) : bool;
}
