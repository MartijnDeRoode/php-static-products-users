<?php
require_once '../../_constants.php';

$product = Product::getById($_GET['id']);

if (!$product) {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Bekijken</title>
</head>

<body>
    <h1>Product Bekijken</h1>
    <ul>
        <li><a href="../index.php">Admin</a></li>
    </ul>
    <hr>

    <label for="name">Naam:</label>
    <input type="text" name="name" id="name" required value="<?= $product->getName() ?>" disabled>
    <br>
    <label for="description" style="float: left;">Beschrijving:</label>
    <textarea name="description" id="description" cols="30" rows="10" disabled><?= $product->getDescription() ?></textarea>
    <br>
    <label for="price">Prijs:</label>
    <input type="number" name="price" id="price" step="0.01" min="0" required value="<?= $product->getPrice() ?>" disabled>
    <br>
    <label for="amount">Aantal:</label>
    <input type="number" name="amount" id="amount" min="0" required value="<?= $product->getAmount() ?>" disabled>
    <br><br>
    <a href="./create.php?id=<?= $product->getId() ?>">Bewerken</a>
    <a href="./delete.php?id=<?= $product->getId() ?>">Verwijderen</a>

    <hr>
    <form action="./comment.php" method="post">
        <input type="hidden" name="product" value="<?= $product->getId() ?>">
        <label for="content" style="float: left;">Context:</label>
        <textarea name="content" id="content" cols="50" rows="2"></textarea>
        <input type="submit" value="Comment">
    </form>
    <hr>
    <?php foreach ($product->getComments() as $comment) : ?>
        <div>
            <h3><?= $comment->getName() ?></h3>
            <p><?= $comment->getContent() ?></p>
        </div>
    <?php endforeach; ?>
</body>

</html>