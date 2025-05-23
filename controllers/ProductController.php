<?php
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stock = (int) $_POST['stock'];
    $min = (int) $_POST['min_stock'];
    $max = (int) $_POST['max_stock'];

    // Validasi stok
    if ($stock < $min || $stock > $max || $min >= $max) {
        $error = "Stok harus lebih besar dari minimum dan lebih kecil dari maksimum. Juga pastikan Min < Max.";
        header("Location: ../views/product/index.php?error=" . urlencode($error));
        exit;
    }

    if (isset($_POST['create'])) {
        Product::create($_POST);
        header('Location: ../views/product/index.php?success=Produk ditambahkan');
    }

    if (isset($_POST['update'])) {
        Product::update($_POST['id'], $_POST);
        header('Location: ../views/product/index.php?success=Produk diupdate');
    }
}


if (isset($_GET['delete'])) {
    Product::delete($_GET['delete']);
    header('Location: ../views/product/index.php?success=Produk dihapus');
}
