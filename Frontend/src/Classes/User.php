<?php

class User
{
    //user table fields
    private ?int $id = null;
    private string $username = "";
    private string $password_hash = "";
    private string $email = "";

    function __construct($username, $plain_password, $email)
    {
        $this->username = $username;
        $this->password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            throw new InvalidArgumentException('Invalid email');
        }
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function exist($db): bool
    {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1");
        $stmt->execute([':u' => $this->username, ':e' => $this->email]);
        return (bool)$stmt->fetch();
    }

    public function save($db)
    {
        $insert = $db->prepare("
            INSERT INTO users 
            (username, password_hash, email)
            VALUES (:username, :hash, :email);
        ");
        $insert->execute([
            ':username' => $this->username,
            ':email' => $this->email,
            ':hash' => $this->password_hash
        ]);
    }
}

?>