<?php
    use Dotenv\Dotenv;

    // Use this to play the game
    require "../../vendor/autoload.php";

    // Use this to test code in the terminal/command line
//    require "vendor/autoload.php";

    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

    if (!function_exists('getState')) {
        function getState() {
            return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
        }
    }

    if (!function_exists('setState')) {
        function setState($state) {
            list($a, $b, $c) = unserialize($state);
            $_SESSION['hand'] = $a;
            $_SESSION['board'] = $b;
            $_SESSION['player'] = $c;
        }
    }

    if (!function_exists('database')) {
        function database() {
            return new mysqli($_ENV['DB_HOSTNAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
        }
    }

