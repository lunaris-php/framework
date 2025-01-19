<?php

    namespace Lunaris\Framework\Providers;

    class FrameworkProvider
    {
        public function getCommands() {
            return [
                "make:controller" => \Lunaris\Framework\Commands\MakeController::class,
                "make:module" => \Lunaris\Framework\Commands\MakeModule::class
            ];
        }
    }