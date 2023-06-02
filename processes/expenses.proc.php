<?php

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once '../auxiliaries.php';
    require_once '../config.php';

    $year = $_GET['year'] ?? date('Y'); // GET THE YEAR FROM THE QUERY PARAMETER OR DEFAULT TO THE CURRENT YEAR

    $expenses = calculateTotalExpensesByMonth($conn,$year);

    echo json_encode($expenses);
} else {
    echo json_encode(['error' => 'Method not allowed']);
}