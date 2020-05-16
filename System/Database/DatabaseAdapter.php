<?php

namespace Database;

class DatabaseAdapter {

    private $dbConnection;

    public function __construct($driver, $hostname, $username, $password, $database, $port) {
        $class = '\Database\DB\\' . $driver;

        if (class_exists($class)) {
            $this->dbConnection = new $class($hostname, $username, $password, $database, $port);
        } else {
            exit('Error: Could not load database driver ' . $driver . '!');
        }
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function query($sql) {
        return $this->dbConnection->query($sql);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function escape($value) {
        return $this->dbConnection->escape($value);
    }

    /**
     * @return mixed
     */
    public function getLastId() {
        return $this->dbConnection->getLastId();
    }
}
