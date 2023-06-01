<?php

require_once '../auxiliaries.php';
require_once '../config.php';

$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if($isPost && isset($_POST['edit']) ) {
    $id = sanitizeInput($_POST['id']);
    $amount = sanitizeInput($_POST['amount']);
    $date = sanitizeInput($_POST['date']);
    $description = sanitizeInput($_POST['description']);
    $category = sanitizeInput($_POST['category']);

    if(empty($amount) || empty($date) || empty($description) || empty($category)) {
        setError('Please fill in all fields', true);
    }

    if(!is_numeric($amount)) {
        setError('Amount must be a number', true);
    }

    if(strlen($description) > 15) {
        setError('Description must be less than 15 characters', true);
    }

    if($date > date('Y-m-d')) {
        setError('Date cannot be in the future', true);
    }

    $update = updateExpense($conn, [
        $amount,
        $date,
        $description,
        $category,
        $id
    ]);

    if($update) {
        setSuccess('Expense updated successfully', [
            'redirect' => './?view=expenses',
            'exit' => true
        ]);
    } else {
        setError('Something went wrong', true);
    }

}