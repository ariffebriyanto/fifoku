<?php require_once __DIR__ . '/../../config.php';
include TEMPLATE_PATH . 'header.php';  ?>
<?php
require_once '../../models/Product.php';
$product = Product::find($_GET['id']);
include '../layout.php';
?>

<h2>✏️ Edit Produk</h2>
<form action="../../controllers/ProductController.php" method="POST">
    <input type="hidden" name="update" value="1">
    <input type="hidden" name="id" value="<?= $product->id ?>">
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" value="<?= $product->name ?>" required>
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stock" class="form-control" value="<?= $product->stock ?>" required>
    </div>
    <div class="mb-3">
        <label>Stok Minimum</label>
        <input type="number" name="min_stock" class="form-control" value="<?= $product->min_stock ?>" required>
    </div>
    <div class="mb-3">
        <label>Stok Maksimum</label>
        <input type="number" name="max_stock" class="form-control" value="<?= $product->max_stock ?>" required>
    </div>
    <button class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include TEMPLATE_PATH . 'footer.php'; ?>
