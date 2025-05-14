<?php
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Product.php';
$products = Product::all();
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/header.php'); ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

                <?php $fifoStocks = Product::getFIFOStockData($_COOKIE['SEARCH_PRODUCT_CHART']); ?>

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
                                                    <span class="badge bg-danger text-white"><i class="fas fa-ban"></i> Dibawah Minimum</span>
                                                <?php elseif ($p->stock <= $p->min_stock + 3): ?>
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Mendekati Minimum</span>
                                                <?php elseif ($p->stock > $p->max_stock): ?>
                                                    <span class="badge bg-danger text-white"><i class="fas fa-ban"></i> Melebihi Maksimum</span>
                                                <?php elseif ($p->stock >= ($p->max_stock - 3)): ?>
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Hampir Penuh</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success text-white"><i class="fas fa-check-circle"></i> Aman</span>
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
                        <h6 class="m-0 font-weight-bold">Grafik Stok</h6>
                    </div>
                    <div class="card-body">
                        <form class="form-inline">
                            <div class="form-group mx-sm-3 mb-3">
                                <select class="select-product" name="select-product" id="select-product">
                                    <option value="0">-- Pilih Semua Produk --</option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn btn-primary mb-2 btn-search-product-chart">Pilih Produk</button>
                        </form>
                        <canvas id="fifoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('fifoChart').getContext('2d');

    const fifoChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($fifoStocks, 'name')) ?>,
            datasets: [{
                    label: 'Stok saat ini',
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
                    backgroundColor: 'red',
                    borderWidth: 2
                },
                {
                    label: 'Max Stok',
                    data: <?= json_encode(array_column($fifoStocks, 'max_stock')) ?>,
                    type: 'line',
                    borderColor: 'orange',
                    backgroundColor: 'orange',
                    borderWidth: 2
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

    $('.select-product').select2();
    $('.btn-search-product-chart').click(function() {
        var prod_id = $('.select-product').val();
        getDataProductChart(prod_id);
    });
    $('#productTable').DataTable({
        "pageLength": 10, // default pagination
        "order": [
            [0, "asc"]
        ], // urutkan kolom pertama (Nama) secara ascending
        "columnDefs": [{

            } // nonaktifkan sort di kolom Aksi
        ]
    });

    function getDataProductChart(product_id) {
        createCookie("SEARCH_PRODUCT_CHART", product_id, 1);
    }

    function createCookie(name, value, days) {
        let expires;

        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }

        document.cookie = escape(name) + "=" +
            escape(value) + expires + "; path=/";
    }
</script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/inventory-system/templates/footer.php'); ?>