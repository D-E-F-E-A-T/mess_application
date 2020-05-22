<?php

namespace Model\Services;

class Container
{
    /**
     * @var array
     */
    private $servicesPool;

    /**
     * @var self
     */
    private static $instance = null;

    private function __construct()
    {
        $this->servicesPool = [];
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (\is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $serviceFqn)
    {
        if ($instance = ($this->servicesPool[$serviceFqn] ?? null)) {
            return $instance;
        }

        switch ($serviceFqn) {
            case UserManager::class:
                $instance = new UserManager();
                break;
            case SessionManager::class:
                $instance = new SessionManager();
                break;
            case SecurityManager::class:
                $instance = new SecurityManager(
                    $this->get(SessionManager::class),
                    $this->get(UserManager::class)
                );
                break;
            case MessageManager::class:
                $instance = new MessageManager();
                break;
        }

        if ($instance instanceof $serviceFqn) {
            $this->servicesPool[$serviceFqn] = $instance;
        } else {
            throw new \RunTimeException("Unable to found service: $serviceFqn", 1);
        }

        return $instance;
    }
}