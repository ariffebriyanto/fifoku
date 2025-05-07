<?php
// config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Path ke root project
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/inventory-system/');

// Shortcut ke folder template
define('TEMPLATE_PATH', BASE_PATH . 'templates/');

// Shortcut ke folder views
define('VIEW_PATH', BASE_PATH . 'views/');

// Shortcut ke folder controllers dan models jika diperlukan
define('MODEL_PATH', BASE_PATH . 'models/');
define('CONTROLLER_PATH', BASE_PATH . 'controllers/');
