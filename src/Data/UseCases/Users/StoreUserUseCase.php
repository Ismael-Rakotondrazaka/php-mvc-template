<?php

namespace App\Data\UseCases\Users;

use App\Core\Utils\Failures\ServerFailure;
use App\Core\Utils\Strings\RandomString;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Data\Models\UserModel;
use App\Core\Utils\Failures\Failure;
use DateTime;

class StoreUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute($firstName, $lastName, $email, $password)
    {
        try {
            $randomStringGenerator = new RandomString(UserModel::ID_CHARACTERS);
            $id = $randomStringGenerator->generate(UserModel::ID_LENGTH);

            $user = new UserModel($id, $firstName, $lastName, $email, $password, null, null, null);

            $this->userRepository->save($user->getId(), $user->getFirstName(), $user->getLastName(), $user->getEmail(), $user->getHashedPassword(), $user->getCreatedAt()->format(DateTime::ATOM), $user->getUpdatedAt()->format(DateTime::ATOM));

            // ! lock to make read only
            $user->lock();

            return $user->getRaw();
        } catch (\Throwable $th) {
            if ($th instanceof Failure) {
                return $th;
            } else {
                return new ServerFailure();
            }
        }
    }
}