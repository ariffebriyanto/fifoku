<?php
require_once 'Database.php';

class Inventory
{
    public static function create($data)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO inventory (product_id, quantity, type, sisa, note, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['product_id'],
            $data['quantity'],
            $data['type'],
            $data['sisa'],
            $data['note'],
            $data['created_at']
        ]);
    }

    public static function all($productId = 0)
    {
        $pdo = Database::getInstance();
        if ($productId > 0) {
            $WHERE = " WHERE  products.id = $productId";
        } else {
            $WHERE = " ";
        }
        $q = "SELECT inventory.*, products.name as product_name, products.satuan as satuan 
                             FROM inventory 
                             JOIN products ON inventory.product_id = products.id 
                             $WHERE
                             ORDER BY inventory.created_at DESC";
        $stmt = $pdo->query($q);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function updateSisa($id, $sisa)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE inventory SET sisa = ? WHERE id = ?");
        return $stmt->execute([$sisa, $id]);
    }

    public static function getInventoryIn($productId)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id, product_id, quantity, type, sisa, created_at
                             FROM inventory
                             WHERE product_id = $productId AND type='in' AND sisa > 0
                             ORDER BY created_at ASC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
