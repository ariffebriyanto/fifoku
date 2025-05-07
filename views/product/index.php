<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<?php
require_once '../../models/Product.php';
$products = Product::all();
include '../layout.php';
?>

<h2>📦 Daftar Produk</h2>
<a href="create.php" class="btn btn-primary mb-3">+ Tambah Produk</a>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<table id="productTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Stok</th>
            <th>Min</th>
            <th>Max</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p->name ?></td>
                <td><?= $p->stock ?></td>
                <td><?= $p->min_stock ?></td>
                <td><?= $p->max_stock ?></td>
                <td>
                    <a href="edit.php?id=<?= $p->id ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="../../controllers/ProductController.php?delete=<?= $p->id ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#productTable').DataTable({
        "pageLength": 10,         // default pagination
        "order": [[0, "asc"]],    // urutkan kolom pertama (Nama) secara ascending
        "columnDefs": [
            { "orderable": false, "targets": 4 } // nonaktifkan sort di kolom Aksi
        ]
    });
});
</script>
<?php include '../footer.php'; ?>
