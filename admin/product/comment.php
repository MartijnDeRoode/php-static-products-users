<?php
require_once '../../_constants.php';

if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Location: ../index.php');
    exit;
}

$user = User::getById($_SESSION['user']);
$product = Product::getById($_POST['product']);

$comment = Comment::addComment($product, $user->getUsername(), $_POST['content']);

header('Location: ./index.php?id=' . $product->getId());
