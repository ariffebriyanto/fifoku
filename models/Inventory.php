<?php
require_once 'Database.php';

class Inventory
{
    public static function create($data)
    {
        $pdo = Database::getInstance(); 
        $stmt = $pdo->prepare("INSERT INTO inventory (product_id, quantity, type, created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['product_id'],
            $data['quantity'],
            $data['type'],
            $data['created_at']
        ]);
    }

    public static function all()
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT inventory.*, products.name as product_name 
                             FROM inventory 
                             JOIN products ON inventory.product_id = products.id 
                             ORDER BY inventory.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
