<?php
interface Product
{
    public function create($db);
    public function read($db);
    public function update($db, $product_id);
    public function delete($db);
}