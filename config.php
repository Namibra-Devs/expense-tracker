<?php

require_once 'auxiliaries.php';

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'expense-tracker';

// PDO Connection
try {
    $connection = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    $conn = $connection;

} catch (PDOException $e) {
    systemError('Connection failed: ' . $e->getMessage());
}

// close connection
$connection = null;


