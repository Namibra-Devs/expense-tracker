<?php

require_once 'auxiliaries.php';

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'expense-tracker';

// PDO Connection
try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
    systemError('Connection failed: ' . $e->getMessage());
}