<?php
// app/config.php

// Define database connection parameters
define('DB_HOST', 'localhost'); // Your database host (usually 'localhost' for local development)
define('DB_USER', 'root');     // Your database username (e.g., 'root' for XAMPP/MAMP)
define('DB_PASS', '');         // Your database password (empty by default for XAMPP/MAMP root)
define('DB_NAME', 'ecommerce_db'); // The name of the database you created

// Error reporting for development - TO BE CHANGE IN PRODUCTION
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
