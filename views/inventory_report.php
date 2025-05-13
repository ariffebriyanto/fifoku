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
require_once MODEL_PATH . 'Inventory.php';
$transactions = Inventory::all();
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<div id="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/topbar.php'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Include the dashboard view -->

                <body class="container mt-5">
                    <h2>📋 Laporan Transaksi Inventori (FIFO)</h2>
                    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
                    <a href="../export_excel.php" class="btn btn-success mb-3">⬇️ Export Excel</a>
                    <a href="../export_pdf.php" class="btn btn-danger mb-3">🖨️ Cetak PDF</a>



                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Jenis</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $trx): ?>
                                <tr>
                                    <td><?= htmlspecialchars($trx->product_name) ?></td>
                                    <td><?= $trx->quantity . ' ' . $trx->satuan ?></td>
                                    <td>
                                        <?php if ($trx->type === 'in'): ?>
                                            <span class="badge bg-success">Stok Masuk</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Stok Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y H:i:s', strtotime($trx->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </body>


            </div>
        </div>
    </div>
</div>


</html>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>