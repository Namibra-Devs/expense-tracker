<?php
global $conn;
/**
 * THIS FILE CONTAINS THE CREATE EXPENSE PROCESS
 * THIS FILE IS INCLUDED IN THE ADD EXPENSE VIEW
 * IT IS USED TO CREATE A NEW EXPENSE
 */

require_once '../auxiliaries.php';
require_once '../config.php';

// CHECK IF REQUEST METHOD IS POST AND IF THE SUBMIT BUTTON WAS CLICKED
if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

	$sanitized = [];
    // LOOP THROUGH THE POST ARRAY PERFORMING VALIDATION AND SANITIZATION
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            if ($key == 'submit') {
                continue;
            } else
                setError('Please fill in all fields', options: ['exit' => true]);
        }
        if ($key == 'amount') {
            if (!is_numeric($value)) {
                setError('Amount must be a number', options: ['exit' => true]);
            }
        }

        if ($key == 'description') {
            if (strlen($value) > 15) {
                setError('Description must be less than 15 characters', options: ['exit' => true]);
            }
        }

        if ($key == 'date') {
            if ($value > date('Y-m-d')) {
                setError('Date cannot be in the future', true);
            }
        }

		$sanitized[$key] = sanitizeInput($value);

    }

    // CREATE THE EXPENSE
    $create = createExpense($conn, [
        $_POST['amount'],
        $_POST['date'],
        $_POST['description'],
        $_POST['category'],
    ]);

    // CHECK IF THE EXPENSE WAS CREATED SUCCESSFULLY
    if ($create) {

        // SET SUCCESS MESSAGE AND REDIRECT TO EXPENSES VIEW
        setSuccess('Expense added successfully', [
            'redirect' => './?view=expenses',
            'exit' => true
        ]);
    } else {

        // SET ERROR MESSAGE
        setError('Something went wrong', true);
    }
}
