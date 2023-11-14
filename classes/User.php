<?php

class User
{
    private int $id;
    private string $username;
    private string $password;

    public function __construct(int $id, string $username, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function delete(): bool
    {
        $stmt = Database::prepare('DELETE FROM users WHERE id = :id;');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(string | null $username, string | null $password): bool
    {
        $username = $username ?? $this->username;
        $password = $password ?? $this->password;
        $password = $password ? password_hash($password, PASSWORD_DEFAULT) : $this->password;

        $stmt = Database::prepare('UPDATE users SET username = :username, password = :password WHERE id = :id;');
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Public Functions
    public static function addUser(string $username, string $password): User
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = Database::prepare('INSERT INTO users (username, password) VALUES (:username, :password);');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        return new User(Database::$conn->lastInsertId(), $username, $password);
    }

    public static function getAll(): array
    {
        $stmt = Database::prepare('SELECT * FROM users;');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userObjects = [];
        foreach ($users as $user) {
            $userObjects[] = new User($user['id'], $user['username'], $user['password']);
        }

        return $userObjects;
    }

    public static function getById(int $id): User | bool
    {
        $stmt = Database::prepare('SELECT * FROM users WHERE id = :id;');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? new User($user['id'], $user['username'], $user['password']) : false;
    }

    public static function getByUsername(string $username): User | bool
    {
        $stmt = Database::prepare('SELECT * FROM users WHERE username = :username;');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? new User($user['id'], $user['username'], $user['password']) : false;
    }
}
