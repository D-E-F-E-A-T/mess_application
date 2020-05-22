<?php 


use MVC\Model;

class ModelsSession  extends Model {

    private $currentSession;
    public function createSession(int $userId)
    {
        $_SESSION["userId"] = $userId;
        //$this->clearUserSession($userId);
        $this->currentSession = new Session($userId);
        $this->persisteSession($this->currentSession);

        return $this->currentSession;
    }

    public function getCurrentSession(): ?Session
    {
        if (null !== $this->currentSession) {
            return $this->currentSession;
        }

        if ($userId = $_SESSION['userId'] ?? 0) {
            $session = $this->getSessionByUserId($userId);

            if ($session && $session->isExpired()) {
                return null;
            }

            $this->currentSession = $session;
        }

        return $this->currentSession;
    }

    public function persisteSession(Session $session): bool
    {
        $query = 'insert into session (`user_id`, `created_at`) values (:user_id, :created_at)';
        $params = [
            ':user_id' => $session->getUserId(),
            ':created_at' => $session->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        $statement = $this->dbInstance->getStatement($query);
        $statement->execute($params);

        return false !== $statement;
    }

    public function getSessionByUserId(int $userId): ?Session
    {
        $session = null;
        $query = 'select * from session where user_id = :user_id order by created_at desc limit 1';
        $statement = $this->dbInstance->getStatement($query);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch();

        if (!empty($result)) {
            $session = SessionFactory::create($result);
        }

        return $session;
    }

    /**
     * @return Session[]
     */
    public function getAllActiveSession($offset = 0, $limit = self::LIST_LIMIT): array
    {
        $currentSession = $this->getCurrentSession();
        $userId = null !== $currentSession ? $currentSession->getUserId() : '';
        $query =
            'SELECT session.*, user.email as username FROM session '
            . 'LEFT JOIN user ON user.id = session.user_id '
            . 'WHERE created_at > DATE_SUB(now(), INTERVAL ' . Session::MAX_DURATION . ' SECOND) '
            . 'AND session.user_id <> :user_id '
            . 'GROUP BY user.id '
            . 'ORDER BY session.created_at DESC '
            . 'LIMIT :offset, :limit';
        $statement = $this->dbInstance->getStatement($query);
        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $statement->execute();

        $results = [];

        while ($result = $statement->fetch()) {
            $results[] = SessionFactory::create($result);
        }

        return $results;
    }

    public function clearUserSession(): bool
    {
        if (!$userId = $_SESSION['userId'] ?? null) {
            return true;
        }

        $query = 'delete from session where user_id = :user_id';
        $statement = $this->dbInstance->getStatement($query);
        $statement->bindParam(':user_id', $userId);
        $_SESSION['userId'] = null;
        session_destroy();

        return false !== $this->dbInstance->execute($statement);
    }
}
