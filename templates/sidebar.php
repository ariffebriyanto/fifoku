<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
$base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/inventory-system';
?>
<!-- sidebar.php -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-box-open"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Inventory</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>/views/Dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
	
	

    <!-- Divider -->
    <hr class="sidebar-divider">

 <!-- Menu User Control - Only for Admin -->
   <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= $base_url ?>/views/user/index.php">
                <i class="fas fa-users-cog"></i>
                <span>User Control</span>
            </a>
        </li>
    <?php endif; ?>

    <!-- Menu Produk -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>/views/product/index.php">
            <i class="fas fa-boxes"></i>
            <span>Produk</span>
        </a>
    </li>

    <!-- Menu Transaksi -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>/views/add_transaction.php">
            <i class="fas fa-exchange-alt"></i>
            <span>Transaksi</span>
        </a>
    </li>

    <!-- Menu Laporan -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>/views/inventory_report.php">
            <i class="fas fa-file-alt"></i>
            <span>Laporan Stok</span>
        </a>
    </li>

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
