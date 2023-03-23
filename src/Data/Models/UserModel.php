<?php

namespace App\Data\Models;

use App\Domain\Entities\User;
use \DateTime;

class UserModel extends User
{
    const TABLE_NAME = "users";

    public function __construct($id, $firstName, $lastName, $email, $password, $hashedPassword, $createdAt, $updatedAt)
    {
        $now = (new DateTime())->getTimestamp();

        $createdAtValue = new DateTime();
        if ($createdAt) {
            $createdAtValue = new DateTime($createdAt);
        } else {
            $createdAtValue->setTimestamp($now);
        }

        $updatedAtValue = new DateTime();
        if ($updatedAt) {
            $updatedAtValue = new DateTime($updatedAt);
        } else {
            $updatedAtValue->setTimestamp($now);
        }

        parent::__construct($id, $firstName, $lastName, $email, $password, $hashedPassword, new DateTime($createdAt), new DateTime($updatedAt));
    }
}