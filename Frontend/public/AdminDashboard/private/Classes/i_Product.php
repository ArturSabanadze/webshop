<?php
interface Product
{
    public function create($db);
    public function read($db);
    public function update($db);
    public function delete($db);
}