<?php

class m_2023_02_22_14_28_24_users
{
    const TABLE_NAME = "users";

    public function up(PDO $pdo)
    {
        $statement = $pdo->prepare(
            "CREATE TABLE " . self::TABLE_NAME .
            " (
                id VARCHAR(255) PRIMARY KEY UNIQUE NOT NULL,
                firstName VARCHAR(255) NOT NULL,
                lastName VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
            );"
        );
        $statement->execute();
    }

    public function down(PDO $pdo)
    {
        $statement = $pdo->prepare("DROP TABLE " . self::TABLE_NAME . " ;");
        $statement->execute();
    }
}