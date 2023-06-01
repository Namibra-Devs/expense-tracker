<?php

require_once '../auxiliaries.php';
require_once '../config.php';

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST as $key => $value) {
        if (empty($_POST[$key])) {
            if ($key == 'submit') {
                continue;
            } else
                setError('Please fill in all fields', true);
        }
        if ($key == 'amount') {
            if (!is_numeric($_POST[$key])) {
                setError('Amount must be a number', true);
            }
        }

        if ($key == 'description') {
            if (strlen($_POST[$key]) > 15) {
                setError('Description must be less than 15 characters', true);
            }
        }

        if ($key == 'date') {
            if ($_POST[$key] > date('Y-m-d')) {
                setError('Date cannot be in the future', true);
            }
        }

        sanitizeInput($_POST[$key]);
    }

    $create = createExpense($conn, [
        $_POST['amount'],
        $_POST['date'],
        $_POST['description'],
        $_POST['category'],
    ]);

    if ($create) {
        setSuccess('Expense added successfully', [
            'redirect' => './?view=expenses',
            'exit' => true
        ]);
    } else {
        setError('Something went wrong', true);
    }
}
