<?php

namespace Model\Services;

use Model\Entity\User;
use Model\Factory\UserFactory;
use Model\Utils\DBManager;

class UserManager
{
    /**
     * @var \PDO
     */
    private $dbInstance;

    public function __construct()
    {
        $this->dbInstance = DBManager::getInstance();
    }

    public function getUser(string $email): ?User
    {
        $query = 'select * from user where email = :email';
        $statement = $this->dbInstance->query($query, [':email' => $email]);

        if ($result = $statement->fetch()) {
            return UserFactory::create($result);
        }

        return null;
    }

    public function getUserById(int $userId): ?User
    {
        $query = 'select * from user where id = :id';

        $statement = $this->dbInstance->query($query, [':id' => $userId]);

        if ($result = $statement->fetch()) {
            return UserFactory::create($result);
        }

        return null;
    }

    public function createUser(string $email, string $firstName, string $lastName, string $passwd): bool
    {
        $query = "insert into user (`email`, `first_name`, `last_name`, `passwd`) values (:email, :first_name, :last_name, :passwd)";

        $params = [
            ':email' => $email,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':passwd' => password_hash($passwd, PASSWORD_DEFAULT),
        ];

        $statement = $this->dbInstance->query($query, $params);

        return false !== $statement;
    }
}