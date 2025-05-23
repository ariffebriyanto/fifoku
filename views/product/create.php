<?php include '../layout.php'; ?>
<?php require_once __DIR__ . '/../../config.php';
include TEMPLATE_PATH . 'header.php';  ?>

<h2>Tambah Produk</h2>
<form action="../../controllers/ProductController.php" method="POST">
    <input type="hidden" name="create" value="1">
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stock" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stok Minimum</label>
        <input type="number" name="min_stock" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stok Maksimum</label>
        <input type="number" name="max_stock" class="form-control" required>
    </div>
    <button class="btn btn-success">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include TEMPLATE_PATH . 'footer.php'; ?>

