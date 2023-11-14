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

    if ($user && password_verify($password, $user->getPassword())) {
        $_SESSION['user'] = $user->getId();
        header('Location: /admin/index.php');
        exit;
    } else {
        echo 'Gebruikersnaam en/of wachtwoord is onjuist.';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body style="background-color: #DDDDDD;">
    <h1>Login</h1>
    <ul>
        <li><a href="./signup.php">Registreren</a></li>
    </ul>
    <hr>
    <form action="./login.php" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <input type="submit" value="Inloggen">
    </form>
</body>

</html>