<?php
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Product.php';
$products = Product::all();
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0"></script>


<div id="wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/topbar.php'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Include the dashboard view -->

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">📦 Dashboard Inventori</h1>

                <div class="mb-4">
                    <a href="/inventory-system/views/add_transaction.php" class="btn btn-primary me-2">
                        <i class="fas fa-plus-circle"></i> Tambah Transaksi
                    </a>
                    <a href="/inventory-system/views/inventory_report.php" class="btn btn-secondary">
                        <i class="fas fa-file-alt"></i> Laporan Transaksi
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
                <?php endif; ?>

                <?php $fifoStocks = Product::getFIFOStockData(); ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Status Stok Produk</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productTable" class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Stok Saat Ini</th>
                                        <th>Min</th>
                                        <th>Max</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $p): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($p->name) ?></td>
                                            <td><?= $p->stock ?></td>
                                            <td><?= $p->min_stock ?></td>
                                            <td><?= $p->max_stock ?></td>
                                            <td>
                                                <?php if ($p->stock < $p->min_stock): ?>
                                                    <span class="badge bg-danger"><i class="fas fa-exclamation-triangle"></i> Stok Rendah</span>
                                                <?php elseif ($p->stock > $p->max_stock): ?>
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Melebihi Maksimum</span>
                                                <?php elseif ($p->stock >= ($p->max_stock - 3)): ?>
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Hampir Penuh</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Aman</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold">Grafik Stok FIFO</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="fifoChart"></canvas>
                    </div>
                </div>
                <script>
                    const ctx = document.getElementById('fifoChart').getContext('2d');

                    const fifoChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode(array_column($fifoStocks, 'name')) ?>,
                            datasets: [{
                                    label: 'Stok (FIFO)',
                                    data: <?= json_encode(array_column($fifoStocks, 'stock')) ?>,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Min Stok',
                                    data: <?= json_encode(array_column($fifoStocks, 'min_stock')) ?>,
                                    type: 'line',
                                    borderColor: 'red',
                                    borderWidth: 2,
                                    fill: false,
                                    pointRadius: 0,
                                    tension: 0
                                },
                                {
                                    label: 'Max Stok',
                                    data: <?= json_encode(array_column($fifoStocks, 'max_stock')) ?>,
                                    type: 'line',
                                    borderColor: 'orange',
                                    borderWidth: 2,
                                    fill: false,
                                    pointRadius: 0,
                                    tension: 0
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });


                    $('#productTable').DataTable({
                        "pageLength": 10, // default pagination
                        "order": [
                            [0, "asc"]
                        ], // urutkan kolom pertama (Nama) secara ascending
                        "columnDefs": [{
                                "orderable": false,
                                "targets": 4
                            } // nonaktifkan sort di kolom Aksi
                        ]
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>