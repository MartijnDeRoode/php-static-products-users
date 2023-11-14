<?php
require_once '../_constants.php';

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);

    header('Location: /login.php');
    exit;
}
