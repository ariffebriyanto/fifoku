<!-- topbar.php -->
<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
$role = $_SESSION['role'] ?? 'guest';
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <!-- Example of a User Profile Dropdown -->
        <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
            <?= htmlspecialchars($user->username ?? 'Guest') ?> (<?= $role ?>)
        </span>
        <?php if ($role === 'admin'): ?>
            <i class="fas fa-user-shield fa-lg text-warning"></i>
        <?php elseif ($role === 'user'): ?>
            <i class="fas fa-user fa-lg text-primary"></i>
        <?php else: ?>
            <i class="fas fa-user-circle fa-lg text-secondary"></i>
        <?php endif; ?>
    </a>

    <!-- Dropdown - User Information -->
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
