<?php

require_once 't_Product.php';
require_once 'i_Product.php';

class Product_P implements Product
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
    private string $product_id = "";
    private int $stock = 0;
    private float $weight = 0.0;
    private float $pack_size_height = 0.0;
    private float $pack_size_width = 0.0;
    private float $pack_size_depth = 0.0;
    private bool $shipping_required = true;


    function __construct(array $product_data)
    {
        // General product fields
        $this->title = $product_data['title'] ?? "";
        $this->description = $product_data['description'] ?? "";
        $this->image_url = $product_data['image_url'] ?? "";
        $this->price = (float) ($product_data['price'] ?? 0.0);
        $this->status = $product_data['status'] ?? "inactive";
        $this->created_at = date('Y-m-d H:i:s');
        $this->start_selling_date = $product_data['start_selling_date'] ?? date('Y-m-d H:i:s');

        // Physical product specific fields
        $this->product_id = $product_data['product_id'] ?? "";
        $this->stock = (int) ($product_data['stock'] ?? 0);
        $this->weight = (float) ($product_data['weight'] ?? 0.0);
        $this->pack_size_height = (float) ($product_data['pack_size_height'] ?? 0.0);
        $this->pack_size_width = (float) ($product_data['pack_size_width'] ?? 0.0);
        $this->pack_size_depth = (float) ($product_data['pack_size_depth'] ?? 0.0);
        $this->shipping_required = (bool) ($product_data['shipping_required'] ?? true);
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

        $insert = $db->prepare("
            INSERT INTO physical_products
            (product_id, stock, weight, pack_size_height, pack_size_width, pack_size_depth, shipping_required)
            VALUES (:product_id, :stock, :weight, :pack_size_height, :pack_size_width, :pack_size_depth, :shipping_required);
        ");
        $insert->execute([
            ':product_id' => $this->id,
            ':stock' => $this->stock,
            ':weight' => $this->weight,
            ':pack_size_height' => $this->pack_size_height,
            ':pack_size_width' => $this->pack_size_width,
            ':pack_size_depth' => $this->pack_size_depth,
            ':shipping_required' => $this->shipping_required
        ]);

    }
    public function read($db)
    {
        $stmt = $db->prepare("
               SELECT 
                   products.*,
                   physical_products.*
               FROM products
               JOIN physical_products 
               ON products.id = physical_products.product_id
           ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($db, $product_id)
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
            WHERE id = $product_id;
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

        $update = $db->prepare("
            UPDATE physical_products SET
            stock = :stock,
            weight = :weight,
            pack_size_height = :pack_size_height,
            pack_size_width = :pack_size_width,
            pack_size_depth = :pack_size_depth,
            shipping_required = :shipping_required
            WHERE product_id = $product_id;
        ");
        $update->execute([
            ':stock' => $this->stock,
            ':weight' => $this->weight,
            ':pack_size_height' => $this->pack_size_height,
            ':pack_size_width' => $this->pack_size_width,
            ':pack_size_depth' => $this->pack_size_depth,
            ':shipping_required' => $this->shipping_required,
            ':product_id' => $this->id
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