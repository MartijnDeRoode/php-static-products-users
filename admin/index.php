<?php
require_once '../_constants.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body style="background-color: #DDDDDD;">
    <h1>Home</h1>
    <ul>
        <li><a href="./logout.php">Uitloggen</a></li>
        <li><a href="./product/create.php">Product Aanmaken</a></li>
    </ul>
    <hr>
    <table>
        <thead>
            <th>Id</th>
            <th>Naam</th>
            <th>Prijs</th>
            <th>Aantal</th>
            <th>Acties</th>
        </thead>
        <tbody>
            <?php foreach (Product::getAll() as $product) : ?>
                <tr>
                    <td><?= $product->getId() ?></td>
                    <td><a href="./product/index.php?id=<?= $product->getId() ?>"><?= $product->getName() ?></a></td>
                    <td><?= $product->getPrice() ?></td>
                    <td><?= $product->getAmount() ?></td>
                    <td>
                        <a href="./product/create.php?id=<?= $product->getId() ?>">Bewerken</a>
                        <a href="./product/delete.php?id=<?= $product->getId() ?>">Verwijderen</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>