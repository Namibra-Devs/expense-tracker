<?php

/**
 * THIS FILE CONTAINS ALL THE AUXILIARY FUNCTIONS
 * IT IS REQUIRED IN ALL THE PROCESS FILES AND OTHER IMPORTANT FILES
 */

// START SESSION IF NOT STARTED
function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}


// SET ERROR MESSAGE IN SESSION
function setError(string $message, array $options = [
    'redirect' => false,
    'exit' => false
]): void
{
    startSession();

    $_SESSION['error'] = $message; // SET THE ERROR MESSAGE IN SESSION

    // CHECK IF REDIRECT IS SET AND IF IT IS NOT FALSE
    if (
        isset($options['redirect']) &&
        $options['redirect'] !== false
    ) {
        header("Location: ../{$options['redirect']}");
    } else {
        header("Location: ./error.php");
    }

    // CHECK IF EXIT IS SET AND IF IT IS NOT FALSE
    if ($options = ['exit']) {
        exit;
    }
}




// SET SUCCESS MESSAGE IN SESSION
function setSuccess(string $message, array $options = [
    'redirect' => null,
    'exit' => false
]): void
{
    startSession();

    $_SESSION['success'] = $message;
    if ($options['redirect'] !== null) {
        header("Location: ../{$options['redirect']}");
    }
    if ($options['exit']) {
        exit;
    }
}



// FUNCTION TO READ ERROR MESSAGE FROM SESSION
function readError(): string
{
    $error = $_SESSION['error'] ?? 'Something went wrong';
    unset($_SESSION['error']);

    return $error;
}

/**
 * FUNCTION TO GET USER'S EXPENSES FROM DATABASE
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @param int $id USER ID
 * @return array ARRAY OF EXPENSES
 */
function getExpenses(PDO $conn, array $options = [
    'sort' => 'date', 
    'order' => 'DESC',
    'filter_year_month' => null
])
{
    // SORT BY DATE 
    if(isset($options['filter_year_month'])) {
        $getAllExpenses = "SELECT * FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = ? ORDER BY {$options['sort']} {$options['order']}"; 
    } else {
        $getAllExpenses = "SELECT * FROM expenses ORDER BY {$options['sort']} {$options['order']}";
    }
    $stmt = $conn->prepare($getAllExpenses);
    if(isset($options['filter_year_month'])) {
        $stmt->execute([$options['filter_year_month']]);
    } else {
        $stmt->execute();
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    return $result;
}


/**
 * FUNCTION TO GET USER'S EXPENSES FROM DATABASE
 * @param PDO $conn DATABASE CONNECTION 
 * @param int $id USER ID
 * @return array|false ARRAY OF EXPENSE OR FALSE IF NOT FOUND
 */
function getExpense(PDO $conn, int $id): array | false
{

    $getExpense = "SELECT * FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($getExpense);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}


/**
 * FUNCTION TO GET USER'S EXPENSES FROM DATABASE
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @param int $id USER ID
 * @return bool `TRUE` IF SUCCESSFUL OR `FALSE` IF NOT
 */
function deleteExpense(PDO $conn, int $id): bool
{
    $deleteExpense = "DELETE FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($deleteExpense);
    return $stmt->execute([$id]);
}


/**
 * FUNCTION TO CREATE A NEW EXPENSE
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @param array $expense ARRAY OF EXPENSE DETAILS
 * @return bool `TRUE` IF SUCCESSFUL OR `FALSE` IF NOT
 */
function createExpense(PDO $conn, array $expense): bool
{
    $createExpense = "INSERT INTO expenses (amount, date, description, category) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($createExpense);
    return $stmt->execute($expense);
}


/**
 * FUNCTION TO UPDATE AN EXPENSE
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @param array $expense ARRAY OF EXPENSE DETAILS
 * @return bool `TRUE` IF SUCCESSFUL OR `FALSE` IF NOT
 */
function updateExpense(PDO $conn, array $expense): bool
{
    $updateExpense = "UPDATE expenses SET amount = ?, date = ?, description = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($updateExpense);
    return $stmt->execute($expense);
}


/**
 * FUNCTION TO GET THE TOTAL EXPENSES FOR THE CURRENT MONTH
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @return float TOTAL EXPENSES FOR THE CURRENT MONTH
 */
function getTotalExpensesForCurrentMonth($conn)
{

    // PREPARE QUERY TO GET TOTAL EXPENSES FOR CURRENT MONTH
    $getTotalExpForMonth = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
    $stmt = $conn->prepare($getTotalExpForMonth);
    $stmt->execute();

    // FETCH THE RESULT
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // GET THE TOTAL EXPENSES FROM THE RESULT
    $totalExpenses = $result['total_expenses'];

    return $totalExpenses;
}

/**
 * FUNCTION TO GET THE TOTAL EXPENSES FOR THE CURRENT MONTH
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @return float TOTAL EXPENSES FOR THE CURRENT MONTH
 */
function calculateAllExpenses(PDO $conn): float
{

    $totalAmount = 0;

    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $totalAmount += $expense['amount'];
    }


    return $totalAmount;
}




/**
 * FUNCTION TO GET THE TOTAL EXPENSES FOR THE CURRENT MONTH
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @return float TOTAL EXPENSES FOR THE CURRENT MONTH
 */
function calculateMonthAverageExpenses($conn): float
{

    $totalAmount = 0;
    $totalCount = 0;
    $avgExpenses = 0;

    $currentMonth = date('Y-m');

    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $expenseDate = date('Y-m', strtotime($expense['date']));

        if ($expenseDate === $currentMonth) {
            $totalAmount += $expense['amount'];
            $totalCount++;
        }
    }

    if ($totalCount > 0) {
        $avgExpenses = $totalAmount / $totalCount;
    }

    return $avgExpenses;
}




/**
 * FUNCTION TO GET THE TOTAL EXPENSES FOR THE CURRENT MONTH
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @return float TOTAL EXPENSES FOR THE CURRENT MONTH
 */
function calculateTotalExpensesByMonth(PDO $conn, int $year): array
{
    $totalExpensesByMonth = array_fill(1, 12, 0);
    $expenses = getExpenses($conn);

    foreach ($expenses as $expense) {
        $expenseDate = date('n', strtotime($expense['date']));
        $expenseYear = date('Y', strtotime($expense['date']));

        if ($expenseYear == $year) {
            $totalExpensesByMonth[$expenseDate] += $expense['amount'];
        }
    }

    return $totalExpensesByMonth;
}





/**
 * FUNCTION TO GET THE TOTAL EXPENSES FOR THE CURRENT MONTH
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @return float TOTAL EXPENSES FOR THE CURRENT MONTH
 */
function getTotalExpensesForCurrentYear(PDO $conn): float
{
    static $memoizedResult = null;

    if ($memoizedResult !== null) {
        return $memoizedResult;
    }

    $totalAmount = 0;
    $totalCount = 0;
    $avgExpenses = 0;

    $currentYear = date('Y');

    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $expenseDate = date('Y', strtotime($expense['date']));

        if ($expenseDate === $currentYear) {
            $totalAmount += $expense['amount'];
            $totalCount++;
        }
    }


    $memoizedResult = $totalAmount;

    return $totalAmount;
}




/**
 * FUNCTION TO ACTIVATE THE CURRENT LINK
 * 
 * @param string $view CURRENT VIEW
 * @param string $link LINK TO ACTIVATE
 */
function activateLink($view, $link)
{
    if ($view === $link) {
        echo 'bg-white text-primary';
    } else {
        echo 'text-white';
    }
}



/**
 * FUNCTION TO SANITIZE INPUTS
 * 
 * @param string $data INPUT TO SANITIZE
 * @return string SANITIZED INPUT
 */
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
