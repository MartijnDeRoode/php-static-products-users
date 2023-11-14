<?php
require_once '../../_constants.php';

$product = Product::getById($_GET['id']);
$product->delete();

header('Location: ../index.php');
exit;
