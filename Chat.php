<?php 
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


class Chat implements MessageComponentInterface
{
    protected $clients = null;
    protected $resource ;
    protected $users = [];

    protected $db = null;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
        try {
            $this->db = new \PDO("mysql:host=" . "localhost" . ";port=" . "3307" . ";dbname=" . "messenger", "root", "Linh@12345", array(\PDO::ATTR_PERSISTENT => true));
            $sql = "SELECT id, userName FROM messenger.auth_account ";
            $query = $this->db->prepare($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $resultSet = $query->fetchAll();
            foreach ($resultSet as $row) {
                echo $row['id'] . '\n';
                }
        } catch(\PDOException $e) {
            trigger_error('Error: Could not make a database link ( ' . $e->getMessage() . '). Error Code : ' . $e->getCode() . ' <br />');
            exit();
        }
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
        $this->resource[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

  
    public function onMessage(ConnectionInterface $from, $msg): void
    {
        foreach ($this->clients as $client) {
            $package = json_decode($msg);

            if (is_object($package) == true) {
                /**
                 * We need to switch the message type because in the future
                 * this could be a message or maybe a request for all chatters
                 * in the chat. For now we only use the message type but we can
                 * build on that later.
                 */
                switch ($package->type) {
                case 'message':
                    if ($from != $client) {
                        if (empty($package->to_user) == false) {


                            /**
                             * Find the client to send the message to
                             */
                            foreach ($this->users as $resourceId => $user) {
                                if ($resourceId == $from->resourceId) {
                                 
                                    continue;
                                }

                                if ($user['user']->id == $package->to_user->id) {

                                    $targetClient = $user['client'];
                                    $targetClient->send($msg);
                                    return;
                                }
                            }
                        }
                        $client->send($msg);
                    }
 
                    break;
                case 'registration':
                    echo $from->resourceId;
                    $this->users[$from->resourceId] = [
                      'user' => $package->user,
                      'client' => $from
                    ];
                    break;
                case 'userlist':
                    $list = [];
                    foreach ($this->users as $resourceId => $value) {
                        $list[] = $value['user'];
                    }
                    $new_package = [
                      'users' => $list,
                      'type' => 'userlist'
                    ];
                    $new_package = json_encode($new_package);
                    $client->send($new_package);
                    break;

                case 'typing':
                    if ($from != $client) {

                        if (empty($package->user) == false) {
                            /**
                             * Find the client to send the message to
                             */
                            foreach ($this->users as $resourceId => $user) {
                                if ($resourceId == $from->resourceId) {
                                    continue;
                                }

                                $new_package = [
                                  'user' => $package->user,
                                  'type' => 'typing',
                                  'value' => $package->value,
                                ];

                                $targetClient = $user['client'];
                                $targetClient->send($msg);
                            }
                        }
                    }
                    break;
                }
            }
        }
    }

    /**
     * The onclose callback.
     *
     * @param ConnectionInterface $conn The unique connection identifier.
     *
     * @return void
     */
    public function onClose(ConnectionInterface $conn): void
    {
        unset($this->users[$conn->resourceId]);
        $this->clients->detach($conn);
    }

    /**
     * The onError callback. Will be called on you guessed it, an error :)
     *
     * @param ConnectionInterface $conn The unique connection identifier.
     * @param Exception           $e    The raised exception
     *
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        unset($this->users[$conn->resourceId]);
        $conn->close();
    }
}
