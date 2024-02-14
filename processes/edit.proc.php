<?php

/**
 * THIS FILE HANDLES THE EDIT EXPENSE PROCESS
 */

require_once '../auxiliaries.php';
require_once '../config.php';

// CHECK IF REQUEST METHOD IS POST
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

// CHECK IF THE EDIT BUTTON WAS CLICKED AND IF THE REQUEST METHOD IS POST
if($isPost && isset($_POST['edit']) ) {

    // SANITIZE THE INPUTS
    $id = sanitizeInput($_POST['id']);
    $amount = sanitizeInput($_POST['amount']);
    $date = sanitizeInput($_POST['date']);
    $description = sanitizeInput($_POST['description']);
    $category = sanitizeInput($_POST['category']);

    // VALIDATE THE INPUTS
    if(empty($amount) || empty($date) || empty($description) || empty($category)) {
        setError('Please fill in all fields', ['exit' => true]);
    }

    if(!is_numeric($amount)) {
        setError('Amount must be a number', ['exit' => true]);
    }

    if(strlen($description) > 15) {
        setError('Description must be less than 15 characters', ['exit' => true]);
    }

    if($date > date('Y-m-d')) {
        setError('Date cannot be in the future', ['exit' => true]);
    }
    // VALIDATION ENDS

    // UPDATE THE EXPENSE
    $update = updateExpense($conn, [
        $amount,
        $date,
        $description,
        $category,
        $id
    ]);

    // CHECK IF THE EXPENSE WAS UPDATED SUCCESSFULLY
    if($update) {
        setSuccess('Expense updated successfully', [
            'redirect' => './?view=expenses',
            'exit' => true
        ]);
    } else {
        setError('Something went wrong', ['exit' => true]);
    }
}
