<?php
/**
 * THIS FILE HANDLES THE DELETE EXPENSE PROCESS
 */

session_start();

require_once '../auxiliaries.php';
require_once '../config.php';

$referer = $_SERVER['HTTP_REFERER'] ?? null; // GET THE REFERER
$requestMethod = $_SERVER['REQUEST_METHOD'] === 'GET'; // CHECK IF REQUEST METHOD IS GET

if (
    $requestMethod && // IF REQUEST METHOD IS GET
    ($referer !== null && str_contains($referer, 'http://localhost:8080/?view=expenses')) // AND REFERER IS FROM EXPENSES PAGE
) {
    $id = $_GET['id'] ?? null; // GET THE ID FROM THE QUERY PARAMS

    if ($id === null) {
        http_response_code(400);
        setError('No id provided', true);
    }

    $result = deleteExpense($conn, $id); // DELETE THE EXPENSE

    if ($result) {
        http_response_code(200);
        setSuccess('Expense deleted', [
            'redirect' => './?view=expenses',
            'exit' => true
        ]);
    } else {
        http_response_code(500);
        setError('Something went wrong', true);
    }
} else {
    http_response_code(405);
    setError('Method not allowed', true);
}
