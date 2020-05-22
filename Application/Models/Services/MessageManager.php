<?php

namespace Model\Services;

use Model\Entity\Message;
use Model\Factory\MessageFactory;
use Model\Utils\DBManager;

class MessageManager
{
    private const LIST_LIMIT = 10;

    /**
     * @var \PDO
     */
    private $dbInstance;

    public function __construct()
    {
        $this->dbInstance = DBManager::getInstance();
    }

    /**
     * @return Message[]
     */
    public function getMessageList(int $senderId, int $receiverId, $offset = 0, $limit = self::LIST_LIMIT): array
    {
        $query =
            'SELECT message.* FROM message '
            . 'WHERE (sender_id = :sender_id AND receiver_id = :receiver_id) '
            . 'OR (receiver_id = :sender_id AND sender_id = :receiver_id) '
            . 'ORDER BY message.created_at DESC '
            . 'LIMIT :offset, :limit';
        $statement = $this->dbInstance->getStatement($query);
        $statement->bindParam(':sender_id', $senderId);
        $statement->bindParam(':receiver_id', $receiverId);
        $statement->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $this->dbInstance->execute($statement);

        $results = [];

        while ($result = $statement->fetch()) {
            array_unshift($results, MessageFactory::create($result));
        }

        return $results;
    }

    public function createMessage(int $senderId, int $receiverId, string $content)
    {
        $createdAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $query = 'insert into message (`sender_id`, `receiver_id`, `content`, `created_at`) values (:sender_id, :receiver_id, :content, :created_at)';

        $statement = $this->dbInstance->getStatement($query);
        $statement->bindParam(':sender_id', $senderId);
        $statement->bindParam(':receiver_id', $receiverId);
        $statement->bindParam(':content', $content);
        $statement->bindParam(':created_at', $createdAt->format('Y-m-d H:i:s'));

        $this->dbInstance->execute($statement);

        return false !== $statement;
    }
}