<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
$role = $_SESSION['role'] ?? 'guest';

require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'Product.php';

// Ambil notifikasi stok
$stockNotifications = Product::getStockAlerts();
$notifCount = count($stockNotifications);
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

        <!-- Notifikasi Stok -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <?php if ($notifCount > 0): ?>
                    <span class="badge badge-danger badge-counter"><?= $notifCount ?></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Notifikasi Stok</h6>
                <?php if ($notifCount > 0): ?>
                    <?php foreach ($stockNotifications as $product): ?>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div>
                                <div class="small text-gray-500"><?= htmlspecialchars($product->name) ?></div>
                                <span class="font-weight-bold text-danger">
                                    Stok: <?= $product->stock ?> <?= $product->satuan ?> |
                                    Min: <?= $product->min_stock ?>, Max: <?= $product->max_stock ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a class="dropdown-item text-center small text-gray-500">Tidak ada notifikasi</a>
                <?php endif; ?>
            </div>
        </li>

        <!-- Profil Pengguna -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= htmlspecialchars(is_array($user) ? ($user['username'] ?? 'Guest') : ($user->username ?? 'Guest')) ?> (<?= $role ?>)
                </span>
                <?php if ($role === 'admin'): ?>
                    <i class="fas fa-user-shield fa-lg text-warning"></i>
                <?php elseif ($role === 'user'): ?>
                    <i class="fas fa-user fa-lg text-primary"></i>
                <?php else: ?>
                    <i class="fas fa-user-circle fa-lg text-secondary"></i>
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
</nav>
