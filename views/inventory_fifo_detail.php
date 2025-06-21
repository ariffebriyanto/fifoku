<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /inventory-system/login.php");
    exit;
}
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Inventory.php';

$pid = $_GET['pid'] ?? null;
$trxDate = $_GET['trx_date'] ?? null;

if (!$pid || !$trxDate) {
    die("Parameter tidak lengkap.");
}

// Ambil semua stok masuk produk ini sebelum waktu transaksi (FIFO)
$transactions = Inventory::all([
    'product_id' => $pid,
    'type' => 'in',
    'to' => $trxDate,
    'order' => 'DESC'
]);
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail FIFO</title>
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
                    <h2>🧾 Rincian FIFO Transaksi</h2>
                    <a href="javascript:history.back()" class="btn btn-secondary mb-3">← Kembali</a>

                    <p><strong>Produk:</strong> <?= htmlspecialchars($transactions[0]->product_name ?? 'Tidak ditemukan') ?></p>
                    <p><strong>Waktu Transaksi:</strong> <?= date('d M Y H:i:s', strtotime($trxDate)) ?></p>

                    <table id="fifoDetailTable" class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jumlah Masuk</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $index => $trx): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $trx->quantity ?></td>
                                    <td><?= date('d M Y H:i:s', strtotime($trx->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#fifoDetailTable').DataTable({
            "pageLength": 10,
            "order": [[2, "desc"]],
            "bFilter": false
        });
    </script>
</body>

</html>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>
