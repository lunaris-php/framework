<?php

    namespace Lunaris\Framework;

    use Exception;

    use Lunaris\Framework\Http\Router;
    use Lunaris\Framework\Http\CsrfVerifier;

    use Dotenv\Dotenv;

    class Container
    {
        private $path;

        public function __construct($path) {
            $this->path = $path;
        }

        private function loadRoutes($modules) {
            Router::csrfVerifier(new CsrfVerifier());

            $modulesPath = $this->path . '/src/modules/';
            if(count($modules) > 0) {
                foreach($modules as $module) {
                    $routeFile = $modulesPath . $module . '/routes.php';

                    if(file_exists($routeFile)) {
                        require_once $routeFile;
                    }
                }
            }

            Router::start();
        }

        private function loadModules() {
            $modulesFile = $this->path . '/app/config/modules.php';
            if(file_exists($modulesFile)) {
                $modules = include $modulesFile;

                $this->loadRoutes($modules);
            }
        }

        private function loadEnv() {
            $dotenv = Dotenv::createImmutable($this->path . '/', null, false);
            try {
                $dotenv->load();
            } catch (Exception $e) {
                throw new Exception("Error loading .env :: " . $e->getMessage());
            }
        }

        public function init() {
            $this->loadEnv();
            $this->loadModules();
        }
    }