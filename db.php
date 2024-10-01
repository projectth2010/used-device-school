<?php
// Database credentials
$host = 'localhost';  // Change this to your database host
$db = 'yasupada_usedtv';  // Change this to your database name
$user = 'yasupada_usedtv';  // Change this to your database username
$pass = 'usedtv123456';  // Change this to your database password
$charset = 'utf8mb4';  // Database charset

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throws exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetches associative arrays by default
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Disables emulation of prepared statements
];

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If the connection fails, output the error
    die('Database connection failed: ' . $e->getMessage());
}
