<?php

class Product
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $amount;
    private array $comments;

    public function __construct(int $id, string $name, string $description, float $price, int $amount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->amount = $amount;
        $this->comments = Comment::getAllByProduct($this);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function delete(): bool
    {
        $stmt = Database::prepare('DELETE FROM products WHERE id = :id;');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(string | null $name, string | null $description, float | null $price, int | null $amount): bool
    {
        $name = $name ?? $this->name;
        $description = $description ?? $this->description;
        $price = $price ?? $this->price;
        $amount = $amount ?? $this->amount;

        $stmt = Database::prepare('UPDATE products SET name = :name, description = :description, price = :price, amount = :amount WHERE id = :id;');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Public Functions
    public static function addProduct(string $name, string $description, float $price, int $amount): Product
    {
        $stmt = Database::prepare('INSERT INTO products (name, description, price, amount) VALUES (:name, :description, :price, :amount);');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->execute();

        return new Product(Database::$conn->lastInsertId(), $name, $description, $price, $amount);
    }

    public static function getAll(): array
    {
        $stmt = Database::prepare('SELECT * FROM products;');
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $productObjects = [];
        foreach ($products as $product) {
            $productObjects[] = new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['amount']);
        }

        return $productObjects;
    }

    public static function getById(int $id): Product | bool
    {
        $stmt = Database::prepare('SELECT * FROM products WHERE id = :id;');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ? new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['amount']) : false;
    }
}
