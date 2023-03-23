<?php

namespace App\Data\Sources\Users;

use App\Data\Sources\Users\UserSourceInterface;
use App\Data\Models\UserModel;
use PDO;

class MysqlUserSource implements UserSourceInterface
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM :tableName;");
        $statement->bindValue("tableName", UserModel::TABLE_NAME);
        $statement->execute();
        $usersFetched = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($user) {
            return new UserModel($user["id"], $user["firstName"], $user["lastName"], $user["email"], null, $user["password"], $user["createdAt"], $user["updatedAt"]);
        }, $usersFetched);
    }


    public function findById(string $id): UserModel
    {
        $statement = $this->pdo->prepare("SELECT * FROM :tableName WHERE id = :id LIMIT 1;");
        $statement->bindValue("tableName", UserModel::TABLE_NAME);
        $statement->bindValue("id", $id);
        $statement->execute();
        $fetched = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($fetched)) {
            throw new \Exception();
        }

        $user = $fetched[0];

        return new UserModel($user["id"], $user["firstName"], $user["lastName"], $user["email"], null, $user["password"], $user["createdAt"], $user["updatedAt"]);
    }


    public function findByEmail(string $email): UserModel
    {
        $statement = $this->pdo->prepare("SELECT * FROM :tableName WHERE email = :email LIMIT 1;");
        $statement->bindValue("tableName", UserModel::TABLE_NAME);
        $statement->bindValue("email", $email);
        $statement->execute();
        $fetched = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($fetched)) {
            throw new \Exception();
        }

        $user = $fetched[0];

        return new UserModel($user["id"], $user["firstName"], $user["lastName"], $user["email"], null, $user["password"], $user["createdAt"], $user["updatedAt"]);
    }

    public function save(string $id, string $firstName, string $lastName, string $email, string $hashedPassword, string $createdAt, string $updatedAt): void
    {
        $statement = $this->pdo->prepare("INSERT INTO users (id, firstName, lastName, email, password, createdAt, updatedAt) VALUES (:id, :firstName, :lastName, :email, :password, :createdAt, :updatedAt);");

        $statement->bindValue("id", $id);
        $statement->bindValue("firstName", $firstName);
        $statement->bindValue("lastName", $lastName);
        $statement->bindValue("email", $email);
        $statement->bindValue("password", $hashedPassword);
        $statement->bindValue("createdAt", $createdAt);
        $statement->bindValue("updatedAt", $updatedAt);

        $statement->execute();
    }
}