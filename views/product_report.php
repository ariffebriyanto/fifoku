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
$produk = Product::all();
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Produk</title>
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
                        <h2>📋 Laporan Produk</h2>
                        <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
                        <table id="laporanProductTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok saat ini</th>
                                    <th>Stok minimal</th>
                                    <th>Stok maksimal</th>
                                    <th>Satuan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produk as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p->name) ?></td>
                                        <td><?= $p->stock ?></td>
                                        <td><?= $p->min_stock ?></td>
                                        <td><?= $p->max_stock ?></td>
                                        <td><?= $p->satuan ?></td>
                                        <td><a href="<?= $base_url . "/views/product_report_detail.php?pid=" . $p->id ?>" class="btn btn-sm btn-success" title="Lihat Detail"><i class="fas fa-eye"></i></a></td>
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
    $('#laporanProductTable').DataTable({
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