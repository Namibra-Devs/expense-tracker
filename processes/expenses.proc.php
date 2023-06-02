<?php

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once '../auxiliaries.php';
    require_once '../config.php';

    $expenses = calculateTotalExpensesByMonth($conn);

    echo json_encode($expenses);
} else {
    echo json_encode(['error' => 'Method not allowed']);
}