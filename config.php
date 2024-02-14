<?php

/**
 * THIS FILE CONTAINS ALL DATABASE CONFIGURATIONS
 */
require_once 'vendor/autoload.php';
require_once 'auxiliaries.php';

// LOAD ENVIRONMENT VARIABLES
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$server = $_ENV['DB_HOST'] ?: 'localhost';
$username = $_ENV['DB_USERNAME'] ?: 'root';
$password = $_ENV['DB_PASSWORD'] ?: '';
$database = $_ENV['DB_DATABASE'] ?: 'expenses';
$port = $_ENV['DB_PORT'] ?: 3306;



// PDO Connection
try {
    $connection = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn = $connection;
	// echo "Connected to $database at $server successfully";
} catch (PDOException $e) {
	echo "Error connecting to $database at $server: " . $e->getMessage();
    http_response_code(500);
    die($e);
} finally {
    // CLOSE THE CONNECTION WHEN DONE WITH IT TO FREE UP RESOURCES
    $connection = null;
}
