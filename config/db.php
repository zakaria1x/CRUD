<?php
// config/database.php

try {
    $dsn = 'oci:dbname=localhost/XEPDB1'; // Adjust for your Oracle setup
    $username = 'SYSTEM';         // Oracle schema username
    $password = '123';         // Oracle schema password
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>