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

    public static function all($filters = [])
{
    $pdo = Database::getInstance();
    $params = [];
    $where = [];

    if (!empty($filters['product_id'])) {
        $where[] = "inventory.product_id = :product_id";
        $params['product_id'] = $filters['product_id'];
    }

    if (!empty($filters['type'])) {
        $where[] = "inventory.type = :type";
        $params['type'] = $filters['type'];
    }

    if (!empty($filters['from']) && !empty($filters['to'])) {
        $where[] = "DATE(inventory.created_at) BETWEEN :from AND :to";
        $params['from'] = $filters['from'];
        $params['to'] = $filters['to'];
    } elseif (!empty($filters['from'])) {
        $where[] = "DATE(inventory.created_at) >= :from";
        $params['from'] = $filters['from'];
    } elseif (!empty($filters['to'])) {
        $where[] = "DATE(inventory.created_at) <= :to";
        $params['to'] = $filters['to'];
    }

    $whereSql = '';
    if (!empty($where)) {
        $whereSql = 'WHERE ' . implode(' AND ', $where);
    }

    $sql = "SELECT inventory.*, products.name as product_name, products.satuan as satuan 
            FROM inventory 
            JOIN products ON inventory.product_id = products.id 
            $whereSql 
            ORDER BY inventory.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
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
