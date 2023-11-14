<?php
require_once '../../_constants.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['id'] > 0) {
        $product = Product::getById($_POST['id']);
        $product->update($_POST['name'], $_POST['description'], $_POST['price'], $_POST['amount']);
    } else {
        $product = Product::addProduct($_POST['name'], $_POST['description'], $_POST['price'], $_POST['amount']);
    }

    header('Location: ../index.php');
    exit;
}

$product = new Product(0, '', '', 0, 0);

if (isset($_GET['id'])) {
    $product = Product::getById($_GET['id']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product aanmaken</title>
</head>

<body>
    <h1>Product aanmaken</h1>
    <ul>
        <li><a href="../index.php">Admin</a></li>
    </ul>
    <hr>

    <form action="./create.php" method="POST">
        <input type="hidden" name="id" value="<?= $product->getId() ?>">
        <label for="name">Naam:</label>
        <input type="text" name="name" id="name" required value="<?= $product->getName() ?>">
        <br>
        <label for="description" style="float: left;">Beschrijving:</label>
        <textarea name="description" id="description" cols="30" rows="10"><?= $product->getDescription() ?></textarea>
        <br>
        <label for="price">Prijs:</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required value="<?= $product->getPrice() ?>">
        <br>
        <label for="amount">Aantal:</label>
        <input type="number" name="amount" id="amount" min="0" required value="<?= $product->getAmount() ?>">
        <br><br>
        <input type="submit" value="Product <?= $product->getId() > 0 ? 'Aanpassen' : 'Aanmaken' ?>">
    </form>
</body>

</html>