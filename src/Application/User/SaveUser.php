<?php
declare(strict_types=1);

namespace Module\Application\User;

use Module\Domain\User\User;
use Module\Domain\User\UserRepository;

final class SaveUser
{

    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param SaveUserCommand $command
     * @return SaveUserResponse
     */
    public function __invoke(SaveUserCommand $command) : SaveUserResponse
    {
        $user = User::compose(
            $command->name,
            $command->email,
            $command->role
        );
        $response = new SaveUserResponse();
        $response->isSaved = $this->userRepository->save($user);
        $response->savingMessage = $user->savingFeedback($response->isSaved);

        return $response;
    }
}
