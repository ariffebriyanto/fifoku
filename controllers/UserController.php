<?php
require_once __DIR__ . '/../config.php';
require_once MODEL_PATH . 'User.php';

// Handle POST actions (Create / Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        User::create($_POST);
        header('Location: ../views/user/index.php?success=User ditambahkan');
        exit;
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $data = [
            'username' => $_POST['username'],
            'role' => $_POST['role']
        ];

        // Jika password tidak kosong, hash dan update
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        User::update($id, $data);
        header('Location: ../views/user/index.php?success=User diupdate');
        exit;
    }

    if (isset($_POST['delete'])) {
        User::delete($_POST['id']);
        header('Location: ../views/user/index.php?success=User dihapus');
        exit;
    }
}

// Optional: You can also handle GET requests for detail/edit view if needed
