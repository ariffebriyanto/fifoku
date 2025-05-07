<?php 
require_once __DIR__ . '/../../config.php';
include TEMPLATE_PATH . 'header.php'; 

?>
<?php require_once MODEL_PATH . 'User.php'; ?>

<div id="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/topbar.php'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Include the dashboard view -->
				<div class="container mt-4">
    <h3>👤 Manajemen User</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah User</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (User::all() as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->username) ?></td>
                    <td><?= htmlspecialchars($user->role) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $user->id ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $user->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

			</div>
		</div>
	</div>
</div>


<?php include TEMPLATE_PATH . 'footer.php'; ?>
