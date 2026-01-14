<?php

require_once 't_Product.php';
require_once 'i_Product.php';

class Product_L implements Product
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
    // live seminar specific fields
    private string $start_date = "";
    private string $end_date = "";
    private int $location_id = 0;
    private int $min_participants = 0;
    private int $max_participants = 0;

    function __construct(array $product_data)
    {
        // Product fields
        $this->title = $product_data['title'] ?? "";
        $this->description = $product_data['description'] ?? "";
        $this->image_url = $product_data['image_url'] ?? "";
        $this->price = (float) ($product_data['price'] ?? 0.0);
        $this->status = $product_data['status'] ?? "inactive";
        $this->created_at = date('Y-m-d H:i:s');
        $this->start_selling_date = $product_data['start_selling_date'] ?? date('Y-m-d H:i:s');
        // Live seminar specific fields
        $this->start_date = $product_data['start_date'] ?? date('Y-m-d H:i:s');
        $this->end_date = $product_data['end_date'] ?? date('Y-m-d H:i:s');
        $this->location_id = (int) ($product_data['location_id'] ?? 0);
        $this->min_participants = (int) ($product_data['min_participants'] ?? 0);
        $this->max_participants = (int) ($product_data['max_participants'] ?? 0);
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
        if ($db === null) {
            throw new RuntimeException('Database connection is null');
        }
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
        $insert_live_seminar = $db->prepare("
            INSERT INTO live_seminars 
            (product_id, start_date, end_date, location_id, min_participants, max_participants)
            VALUES (:product_id, :start_date, :end_date, :location_id, :min_participants, :max_participants);
        ");
        $insert_live_seminar->execute([
            ':product_id' => $this->id,
            ':start_date' => $this->start_date,
            ':end_date' => $this->end_date,
            ':location_id' => $this->location_id,
            ':min_participants' => $this->min_participants,
            ':max_participants' => $this->max_participants
        ]);
    }

    public function read($db)
    {
        $stmt = $db->prepare("
            SELECT 
                products.*,
                live_seminars.*
            FROM products
            JOIN live_seminars 
            ON products.id = live_seminars.product_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($db, $product_id)
    {
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
        ]);

        $update_live_seminars = $db->prepare("
            UPDATE live_seminars SET
            start_date = :start_date,
            end_date = :end_date,
            location_id = :location_id,
            min_participants = :min_participants,
            max_participants = :max_participants
            WHERE product_id = $product_id;
        ");
        $update_live_seminars->execute([
            ':start_date' => $this->start_date,
            ':end_date' => $this->end_date,
            ':location_id' => $this->location_id,
            ':min_participants' => $this->min_participants,
            ':max_participants' => $this->max_participants
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