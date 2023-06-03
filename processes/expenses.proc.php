<?php
/**
 * THIS FILE HANDLES THE EXPENSES PROCESS
 * IT IS USED TO GET THE TOTAL EXPENSES FOR EACH MONTH OF THE YEAR
 */

header('Content-Type: application/json'); // SET THE RESPONSE HEADER TO JSON

// CHECK IF REQUEST METHOD IS GET
if($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once '../auxiliaries.php';
    require_once '../config.php';

    $year = $_GET['year'] ?? date('Y'); // GET THE YEAR FROM THE QUERY PARAMETER OR DEFAULT TO THE CURRENT YEAR

    $expenses = calculateTotalExpensesByMonth($conn,$year);

    echo json_encode($expenses); // RETURN THE EXPENSES AS JSON
} else {
    echo json_encode(['error' => 'Method not allowed']); // RETURN AN ERROR MESSAGE IF REQUEST METHOD IS NOT GET
}