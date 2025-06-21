<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /inventory-system/login.php");
    exit;
}
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Inventory.php';

$transactions = Inventory::all([
    'type' => $_GET['type'] ?? '',
    'from' => $_GET['from'] ?? '',
    'to'   => $_GET['to'] ?? ''
]);
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

<body class="bg-light">
    <div id="wrapper">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/topbar.php'); ?>

                <div class="container-fluid mt-4">
                    <h2>📋 Laporan Transaksi Inventori (FIFO)</h2>

                    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
                    <a href="../export_excel.php" class="btn btn-success mb-3">⬇️ Export Excel</a>
                    <a href="../export_pdf.php" class="btn btn-danger mb-3">🖨️ Cetak PDF</a>

                    <!-- Filter -->
                    <form method="get" class="row mb-4">
                        <div class="col-md-3">
                            <label for="type">Jenis Transaksi</label>
                            <select name="type" class="form-control">
                                <option value="">-- Semua --</option>
                                <option value="in" <?= isset($_GET['type']) && $_GET['type'] == 'in' ? 'selected' : '' ?>>Stok Masuk</option>
                                <option value="out" <?= isset($_GET['type']) && $_GET['type'] == 'out' ? 'selected' : '' ?>>Stok Keluar</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="from">Dari Tanggal</label>
                            <input type="date" name="from" class="form-control" value="<?= $_GET['from'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="to">Sampai Tanggal</label>
                            <input type="date" name="to" class="form-control" value="<?= $_GET['to'] ?? '' ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">🔍 Filter</button>
                            <a href="<?= $base_url ?>/views/inventory_report.php" class="btn btn-secondary">🔄 Reset</a>
                        </div>
                    </form>

                    <table id="laporanTransaksiProductTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Sisa</th>
                                <th>Satuan</th>
                                <th>Jenis</th>
                                <th>Waktu</th>
								<th>Detil</th> 
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
									<td>
        <a href="<?= $base_url ?>/views/inventory_fifo_detail.php?pid=<?= $trx->product_id ?>&trx_date=<?= urlencode($trx->created_at) ?>" 
           class="btn btn-sm btn-info" title="Lihat FIFO">
            <i class="fas fa-eye"></i>
        </a>
    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#laporanTransaksiProductTable').DataTable({
            "pageLength": 10,
            "order": [
                [5, "desc"]
            ],
            "bFilter": false
        });
    </script>
</body>

</html>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>