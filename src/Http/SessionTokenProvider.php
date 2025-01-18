<?php

    namespace Lunaris\Framework\Http;

    use Pecee\Http\Security\ITokenProvider;

    class SessionTokenProvider implements ITokenProvider
    {
        protected function startSession(): void
        {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
        }

        protected function generateToken(): string
        {
            return bin2hex(random_bytes(32));
        }

        public function refresh(): void
        {
            $this->startSession();
            $_SESSION['csrf_token'] = $this->generateToken();
        }

        public function validate($token): bool
        {
            $this->startSession();
            return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
        }

        public function getToken(?string $defaultValue = null): ?string
        {
            $this->startSession();
            if (isset($_SESSION['csrf_token'])) {
                return $_SESSION['csrf_token'];
            }

            $_SESSION['csrf_token'] = $this->generateToken();
            return $_SESSION['csrf_token'];
        }
    }