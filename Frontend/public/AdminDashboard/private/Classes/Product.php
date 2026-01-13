<?php

class Product
{
    //product table fields
    private ?int $id = null;
    private string $title = "";
    private string $description = "";
    private string $image_url = "";
    private float $price = 0.0;
    private string $status = "inactive";
    private string $created_at = "";
    private string $start_selling_date = "";

    function __construct(array $product_data)
    {
        $this->title = $product_data['title'] ?? "";
        $this->description = $product_data['description'] ?? "";
        $this->image_url = $product_data['image_url'] ?? "";
        $this->price = (float) ($product_data['price'] ?? 0.0);
        $this->status = $product_data['status'] ?? "inactive";
        $this->created_at = date('Y-m-d H:i:s');
        $this->start_selling_date = $product_data['start_selling_date'] ?? date('Y-m-d H:i:s');
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function create($db)
    {
        $insert = $db->prepare("
            INSERT INTO products 
            (title, description, image_url, price, status, created_at, start_selling_date)
            VALUES (:title, :description, :image_url, :price, :status, :created_at, :start_selling_date);
        ");
        $insert->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            ':image_url' => $this->image_url,
            ':price' => $this->price,
            ':status' => $this->status,
            ':created_at' => $this->created_at,
            ':start_selling_date' => $this->start_selling_date
        ]);
        $this->id = $db->lastInsertId();
    }

    public function update($db)
    {
        if ($this->id === null) {
            throw new RuntimeException('Cannot update product without ID');
        }

        $update = $db->prepare("
            UPDATE products SET
            title = :title,
            description = :description,
            image_url = :image_url,
            price = :price,
            status = :status,
            start_selling_date = :start_selling_date
            WHERE id = :id;
        ");
        $update->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            ':image_url' => $this->image_url,
            ':price' => $this->price,
            ':status' => $this->status,
            ':start_selling_date' => $this->start_selling_date,
            ':id' => $this->id
        ]);
    }
}