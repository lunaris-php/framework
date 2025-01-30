<?php

    namespace Lunaris\Framework\Facades;

    class Session {
        public static function get() {
            if(isset($_SESSION[$name]) && !empty($_SESSION[$name]))
            {
                return $_SESSION[$name];
            }
            return false;
        }

        public static function put($name, $value) {
            $_SESSION[$name] = $value;
            return true;
        }

        public static function has($name) {
            if(isset($_SESSION[$name]) && !empty($_SESSION[$name]))
            {
                return true;
            }
            return false;
        }

        public static function delete($name) {
            unset($_SESSION[$name]);
            return true;
        }
    }