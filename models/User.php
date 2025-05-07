<?php
require_once 'Database.php';

class User {
    public static function all() {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

   public static function find($id) {
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}


    public static function create($data) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ]);
    }
	
	public static function findByUsername($username) {
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
    return $stmt->fetch();
}


    public static function update($id, $data) {
    $db = Database::getInstance();

    $fields = ['username = ?', 'role = ?'];
    $params = [$data['username'], $data['role']];

    if (!empty($data['password'])) {
        $fields[] = 'password = ?';
		$data['password'] = md5($_POST['password']); // ← hash dengan md5
        $params[] = $data['password'];
    }

    $params[] = $id;

    $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute($params);
}


   public static function delete($id) {
    $db = Database::getInstance();
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}
}
