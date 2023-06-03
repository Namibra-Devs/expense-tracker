<?php

/**
 * THIS FILE CONTAINS ALL DATABASE CONFIGURATIONS
 */

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
    setError($e->getMessage(), true);
}

// CLOSE THE CONNECTION WHEN DONE WITH IT TO FREE UP RESOURCES
$connection = null;
