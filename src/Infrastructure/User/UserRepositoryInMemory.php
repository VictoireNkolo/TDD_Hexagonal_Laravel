<?php

namespace Module\Infrastructure\User;

use Module\Domain\User\User;
use Module\Domain\User\UserRepository;

class UserRepositoryInMemory implements UserRepository
{

    private User $user;

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        $this->user = $user;
        return true;
    }
}
