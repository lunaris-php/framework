<?php

    namespace Lunaris\Framework\Commands;

    use Lunaris\Framework\Utils\Template;
    use Lunaris\Framework\Commands\MakeController;

    class MakeModule
    {
        private string $path;
        private array $args;

        public function __construct(string $path, array $args) {
            $this->path = $path;
            $this->args = $args;
        }

        public function execute(): void {
            $projectRoot = getcwd();
            $args = Template::getArgs($this->args);

            $moduleName = $args['name'];
            if(!$moduleName) {
                echo "Module name is not present." . PHP_EOL;
                return;
            }

            $modulePath = $this->path . '/src/modules/' . $moduleName;
            $this->createModule($modulePath, $moduleName);
        }

        private function createModule($modulePath, $moduleName) {
            if(is_dir($modulePath)) {
                echo "Module {$moduleName} already exists." . PHP_EOL;
                return;
            }

            mkdir($modulePath, 0755, true);
            mkdir("{$modulePath}/views", 0755, true);

            $controllerName = $moduleName . 'Controller';

            $makeController = new MakeController($this->path, [
                "name={$controllerName}",
                "module={$moduleName}"
            ]);
            $makeController->execute();

            $routerContent = Template::router($moduleName);
            file_put_contents("{$modulePath}/routes.php", $routerContent);

            echo "Module {$moduleName} is created successfully in src/modules.".PHP_EOL;
            echo "Add module name {$moduleName} to App/Config/modules.php to activate the module." . PHP_EOL;
        }
    }