<?php
require_once 'Database.php';

class Product
{
    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function find($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
public static function updateStock($id, $newStock)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE products SET stock = ? WHERE id = ?");
        return $stmt->execute([$newStock, $id]);
    }
    public static function create($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO products (name, stock, min_stock, max_stock) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['stock'], $data['min_stock'], $data['max_stock']]);
    }

    public static function update($id, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE products SET name = ?, stock = ?, min_stock = ?, max_stock = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['stock'], $data['min_stock'], $data['max_stock'], $id]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
	
	public static function getFIFOStockData()
{
    $conn = Database::getInstance();
    $stmt = $conn->prepare("SELECT name, stock, min_stock, max_stock FROM products ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
