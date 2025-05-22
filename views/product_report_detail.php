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
$pid = $_GET['pid'];
$transactions = Inventory::all($pid);
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
                        <h2>📋 Detail Produk</h2>
                        <a href="<?= $base_url ?>/views/product_report.php" class="btn btn-secondary mb-3">← Kembali</a>
                        <table id="laporanDetailProductTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Sisa</th>
                                    <th>Satuan</th>
                                    <th>Jenis</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $trx): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($trx->product_name) ?></td>
                                        <td><?= $trx->quantity ?></td>
                                        <td><?= $trx->sisa ?></td>
                                        <td><?= $trx->satuan ?></td>
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
                    </div>
                </body>


            </div>
        </div>
    </div>
</div>
<script>
    $('#laporanDetailProductTable').DataTable({
        "pageLength": 10, // default pagination
        "order": [
            [0, "asc"]
        ], // urutkan kolom pertama (Nama) secara ascending
        "columnDefs": [{

            } // nonaktifkan sort di kolom Aksi
        ]
    });
</script>

</html>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>