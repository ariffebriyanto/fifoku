<?php
session_start();
session_destroy();
header("Location: /inventory-system/login.php");
exit;
