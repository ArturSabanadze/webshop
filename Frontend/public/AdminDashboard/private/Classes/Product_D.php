<?php

require_once 't_Product.php';
require_once 'i_Product.php';

class Product_D implements Product
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
    // digital product specific fields
    private string $file_url = "";
    private string $license_type = "";

    function __construct(
        array $product_data
    ) {
        $this->title = $product_data['title'] ?? "";
        $this->description = $product_data['description'] ?? "";
        $this->image_url = $product_data['image_url'] ?? "";
        $this->price = (float) ($product_data['price'] ?? 0.0);
        $this->status = $product_data['status'] ?? "inactive";
        $this->created_at = date('Y-m-d H:i:s');
        $this->start_selling_date = $product_data['start_selling_date'] ?? date('Y-m-d H:i:s');
        $this->file_url = $product_data['file_url'] ?? "";
        $this->license_type = $product_data['license_type'] ?? "";
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImgUrl(string $url): void
    {
        $this->image_url = $url;
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
        $insert_digital = $db->prepare("
            INSERT INTO digital_products 
            (product_id, file_url, license_type)
            VALUES (:product_id, :file_url, :license_type);
        ");
        $insert_digital->execute([
            ':product_id' => $this->id,
            ':file_url' => $this->file_url,
            ':license_type' => $this->license_type
        ]);
    }

    public function read($db)
    {
        $stmt = $db->prepare("
    SELECT 
        products.*,
        digital_products.*
    FROM products
    JOIN digital_products 
    ON products.id = digital_products.product_id
");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($db, $product_id)
    {
        if ($this->id === null) {
            throw new RuntimeException('Cannot update product without ID');
        }

        $update_product = $db->prepare("
            UPDATE products SET
            title = :title,
            description = :description,
            image_url = :image_url,
            price = :price,
            status = :status,
            start_selling_date = :start_selling_date
            WHERE id = $product_id;
        ");
        $update_product->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            ':image_url' => $this->image_url,
            ':price' => $this->price,
            ':status' => $this->status,
            ':start_selling_date' => $this->start_selling_date,
            ':id' => $product_id
        ]);

        $update_digital = $db->prepare("
            UPDATE digital_products SET
            file_url = :file_url,
            liciense_type = :liciense_type
            WHERE product_id = $product_id;
        ");
        $update_digital->execute([
            ':file_url' => $this->file_url,
            ':license_type' => $this->license_type,
            ':product_id' => $product_id
        ]);
    }

    public function delete($db)
    {
        if ($this->id === null) {
            throw new RuntimeException('Cannot delete product without ID');
        }

        $delete = $db->prepare("DELETE FROM products WHERE id = :id");
        $delete->execute([':id' => $this->id]);
    }

    use T_Product;

}