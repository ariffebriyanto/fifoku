<?php
require_once __DIR__ . '/../../config.php';
require_once MODEL_PATH . 'User.php';

// Cek apakah ID tersedia di URL
if (!isset($_GET['id'])) {
    die('ID user tidak ditemukan.');
}

$id = $_GET['id'];
$user = User::find($id);

if (!$user) {
    die('User tidak ditemukan.');
}

include '../layout.php';
?>

<h2>🗑️ Hapus Pengguna</h2>

<p>Apakah Anda yakin ingin menghapus user <strong><?= htmlspecialchars($user->username) ?></strong>?</p>

<form method="POST" action="../../controllers/UserController.php">
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <button type="submit" name="delete" class="btn btn-danger">Ya, Hapus</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>
