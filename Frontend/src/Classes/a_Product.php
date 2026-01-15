<?php

abstract class a_Product
{
    protected ?int $id = null;
    protected string $title = "";
    protected string $description = "";
    protected string $image_url = "";
    protected float $price = 0.0;
    protected string $created_at = "";
    protected string $start_selling_date = "";

    function __construct(array $product_data)
    {
        $this->title = $product_data['title'] ?? "";
        $this->description = $product_data['description'] ?? "";
        $this->image_url = $product_data['image_url'] ?? "";
        $this->price = (float) ($product_data['price'] ?? 0.0);
        $this->created_at = $product_data['created_at'] ?? "";
        $this->start_selling_date = $product_data['start_selling_date'] ?? "";
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    abstract public function save($db);
}