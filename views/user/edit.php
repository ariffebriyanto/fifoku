<?php include '../layout.php'; ?>
<?php require_once __DIR__ . '/../../config.php';
include TEMPLATE_PATH . 'header.php';  ?>
<?php
require_once '../../config.php';
require_once MODEL_PATH . 'User.php';

if (!isset($_GET['id'])) {
    die('ID pengguna tidak ditemukan.');
}

$id = $_GET['id'];
$user = User::find($id);

if (!$user) {
    die('Pengguna tidak ditemukan.');
}
?>

<h2>✏️ Edit Pengguna</h2>

<form method="POST" action="../../controllers/UserController.php">
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?= $user->username ?>" required>
    </div>
    <div class="mb-3">
        <label>Password (kosongkan jika tidak ingin mengubah)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>User</option>
        </select>
    </div>
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include TEMPLATE_PATH . 'footer.php'; ?>