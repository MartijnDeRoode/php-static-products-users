<?php

define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', 'root');
define('DATABASE_NAME', 'php_uitbreiding');

// Autoload classes
spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/classes/' . $class . '.php')) {
        require_once __DIR__ . '/classes/' . $class . '.php';
        return;
    }

    require_once __DIR__ . '/' . $class . '.php';
});

// Start session
session_start();

// Check if login is required
if (!defined('IGNORE_LOGIN') || !IGNORE_LOGIN) {
    if (!isset($_SESSION['user'])) {
        header('Location: /login.php');
        exit;
    }
}

// Setup the user
if (isset($_SESSION['user'])) {
    $user = User::getById($_SESSION['user']);

    if (!$user) {
        unset($_SESSION['user']);
        header('Location: /login.php');
        exit;
    }
}
