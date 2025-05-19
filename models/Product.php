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
        $stmt = $db->prepare("INSERT INTO products (name, stock, min_stock, max_stock, satuan) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['name'], $data['stock'], $data['min_stock'], $data['max_stock'], $data['satuan']]);
        return $db->lastInsertId();
    }

    public static function update($id, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE products SET name = ?, stock = ?, min_stock = ?, max_stock = ?, satuan = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['stock'], $data['min_stock'], $data['max_stock'], $data['satuan'], $id]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
	
	public static function getStockAlerts()
{
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM products WHERE stock <= min_stock + 5 OR stock >= max_stock - 5");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


    public static function getFIFOStockData($productId)
    {
        $conn = Database::getInstance();

        if ($productId > 0) {
            $where = " WHERE id = $productId ";
        } else {
            $where = "";
        }
        $query = "SELECT name, stock, min_stock, max_stock, satuan FROM products $where ORDER BY name";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
