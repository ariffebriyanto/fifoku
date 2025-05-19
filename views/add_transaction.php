<?php
session_start();

// Jika belum login, redirect ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: /inventory-system/login.php");
    exit;
}
?>
<?php
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Product.php';
$products = Product::all();
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<div id="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/topbar.php'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Include the dashboard view -->

                <body class="bg-light">
                    <div class="container mt-4">
                        <h3>+ Tambah Transaksi Inventori</h3>
                        <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Kembali ke Dashboard</a>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger"><?= $_GET['error'] ?></div>
                        <?php endif; ?>

                        <form action="../process_transaction.php" method="POST">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Pilih Produk</label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text" name="note" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Transaksi</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="in" required>
                                    <label class="form-check-label">Stok Masuk</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" value="out" required>
                                    <label class="form-check-label">Stok Keluar</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                        </form>
                    </div>
                </body>


            </div>
        </div>
    </div>
</div>



</html>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>