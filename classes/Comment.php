<?php

class Comment
{
    private int $id;
    private Product $product;
    private string $name;
    private string $content;

    public function __construct(int $id, Product $product, string $name, string $content)
    {
        $this->id = $id;
        $this->product = $product;
        $this->name = $name;
        $this->content = $content;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    // Public Functions
    public static function addComment(Product $product, string $name, string $content): Comment
    {
        $stmt = Database::prepare('INSERT INTO comments (product, name, content) VALUES (:product, :name, :content);');
        $stmt->bindParam(':product', $product->getId(), PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();

        return new Comment(Database::$conn->lastInsertId(), $product, $name, $content);
    }

    public static function getAllByProduct(Product $product): array
    {
        $productId = $product->getId();

        $stmt = Database::prepare('SELECT * FROM comments WHERE product = :product;');
        $stmt->bindParam(':product', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $commentObjects = [];
        foreach ($comments as $comment) {
            $commentObjects[] = new Comment($comment['id'], $product, $comment['name'], $comment['content']);
        }

        return $commentObjects;
    }
}
