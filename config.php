<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'management_system');

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5242880);

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
