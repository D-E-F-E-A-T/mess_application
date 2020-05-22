<?php

namespace Model\Services;

use Model\Entity\User;

class SecurityManager
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var SessionManager
     */
    private $sessionManager;

    public function __construct(SessionManager $sessionManager, UserManager $userManager)
    {
        $this->userManager = $userManager;
        $this->sessionManager = $sessionManager;
    }

    public function authenticate(string $email, string $passwd): bool
    {
        $user = $this->userManager->getUser($email);

        if (!$user instanceof User) {
            return false;
        }

        if ($authentication = password_verify($passwd, $user->getHashedPasswd())) {
            $this->sessionManager->createSession($user->getId());
        }

        return $authentication;
    }

    public function getAuthenticatedUser(): ?User
    {
        $currentSession = $this->sessionManager->getCurrentSession();

        if (null !== $currentSession) {
            return $this->userManager->getUserById($currentSession->getUserId());
        }

        return null;
    }

    public function signOut(): bool
    {
        return $this->sessionManager->clearUserSession();
    }
}
