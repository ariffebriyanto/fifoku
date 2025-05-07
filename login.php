<?php
session_start();
require_once 'models/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if ($user) {
        $_SESSION['user'] = $user;
		$_SESSION['role'] = $user->role;
        header('Location: views/dashboard.php');
        exit;
    } else {
        $error = "Username / Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Login</title>
   
   <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/inventory-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        .login-title {
            font-weight: bold;
            color: #4e73df;
            text-align: center;
            margin-bottom: 1rem;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="login-title">Inventory System Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input name="username" id="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
