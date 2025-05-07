<?php require_once __DIR__ . '/../../config.php';
include TEMPLATE_PATH . 'header.php';  ?>

<div class="container mt-4">
    <h3>Tambah User</h3>
    <form action="../../controllers/UserController.php" method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit" name="create" class="btn btn-success">Simpan</button>
    </form>
</div>

<?php include TEMPLATE_PATH . 'footer.php'; ?>
