<?php
define('IGNORE_LOGIN', true);
require_once './_constants.php';

if (defined('USER')) {
    header('Location: /admin/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::getByUsername($username);

    if (!$user) {
        $user = User::addUser($username, $password);
        $_SESSION['user'] = $user->getId();
        header('Location: /admin/index.php');
        exit;
    }

    echo 'Gebruikersnaam bestaat al.';
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Registreren</title>
</head>

<body style="background-color: #DDDDDD;">
    <h1>Registreren</h1>
    <ul>
        <li><a href="./login.php">Inloggen</a></li>
    </ul>
    <hr>
    <form action="./signup.php" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <input type="submit" value="Registreren">
    </form>
</body>

</html>